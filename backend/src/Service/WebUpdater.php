<?php

declare(strict_types=1);

namespace App\Service;

use App\Container\EnvironmentAwareTrait;
use RuntimeException;
use Throwable;

final class WebUpdater
{
    use EnvironmentAwareTrait;

    // Don't worry that this is insecure; it's only ever used for internal communications.
    public const string WATCHTOWER_TOKEN = 'azur4c457';

    public function __construct(
        private readonly GuzzleFactory $guzzleFactory
    ) {
    }

    public function isSupported(): bool
    {
        return $this->environment->enableWebUpdater();
    }

    public function ping(): bool
    {
        if (!$this->isSupported()) {
            return false;
        }

        try {
            $client = $this->guzzleFactory->buildClient();
            $client->get(
                'http://updater:8080/',
                [
                    'http_errors' => false,
                    'timeout' => 5,
                ]
            );

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    public function triggerUpdate(): void
    {
        if (!$this->isSupported()) {
            throw new RuntimeException('Web updates are not supported on this installation.');
        }


        // Step 1: Create backup
        $backupDir = '/var/azuracast/backups';
        $timestamp = date('Ymd_His');
        $backupFile = $backupDir . '/app_backup_' . $timestamp . '.tar.gz';
        $dbBackupFile = $backupDir . '/db_backup_' . $timestamp . '.sql';

        // Create backup directory if not exists
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0775, true);
        }

        // Delete backups older than 30 days
        $deletedBackups = [];
        foreach (glob($backupDir . '/*') as $file) {
            if (is_file($file) && filemtime($file) < strtotime('-30 days')) {
                unlink($file);
                $deletedBackups[] = basename($file);
            }
        }

        // Backup database (assuming MySQL)
        $dbUser = getenv('MYSQL_USER') ?: 'azuracast';
        $dbPass = getenv('MYSQL_PASSWORD') ?: 'azur4c457';
        $dbName = getenv('MYSQL_DATABASE') ?: 'azuracast';
        $dbHost = getenv('MYSQL_HOST') ?: 'localhost';
        $dumpCmd = sprintf('mysqldump -h%s -u%s -p%s %s > %s 2>&1', $dbHost, $dbUser, $dbPass, $dbName, $dbBackupFile);
        exec($dumpCmd, $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('Database backup failed: ' . implode("\n", $output));
        }

        // Backup app files (excluding backups folder)
        $tarCmd = 'tar --exclude="backups" -czf ' . escapeshellarg($backupFile) . ' .';
        exec($tarCmd, $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('App file backup failed: ' . implode("\n", $output));
        }

        // Inform user about deleted backups (could be logged, returned, or shown in UI)
        if (!empty($deletedBackups)) {
            // For now, log to a file. You can surface this in the dashboard if needed.
            file_put_contents($backupDir . '/deleted_backups.log', date('Y-m-d H:i:s') . ' Deleted: ' . implode(', ', $deletedBackups) . "\n", FILE_APPEND);
        }

        // Step 2: Pull latest code from GitHub repo
        $output = [];
        exec('git pull origin main 2>&1', $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('Git pull failed: ' . implode("\n", $output));
        }

        // Step 3: Update PHP dependencies
        $output = [];
        exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('Composer install failed: ' . implode("\n", $output));
        }

        // Step 4: Update JS dependencies and build frontend
        $output = [];
        exec('npm install 2>&1', $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('NPM install failed: ' . implode("\n", $output));
        }
        $output = [];
        exec('npm run build 2>&1', $output, $returnVar);
        if ($returnVar !== 0) {
            throw new RuntimeException('NPM build failed: ' . implode("\n", $output));
        }

        // Step 5: Optionally run database migrations (uncomment if needed)
        // $output = [];
        // exec('php bin/console doctrine:migrations:migrate --no-interaction 2>&1', $output, $returnVar);
        // if ($returnVar !== 0) {
        //     throw new RuntimeException('Database migration failed: ' . implode("\n", $output));
        // }
    }
}
