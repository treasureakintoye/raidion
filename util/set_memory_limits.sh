#!/bin/bash
# Dynamically set memory-related environment variables based on system memory

MEM_TOTAL_MB=$(awk '/MemTotal/ {print int($2/1024)}' /proc/meminfo)

if [ "$MEM_TOTAL_MB" -le 1200 ]; then
  # 1GB server
  export PHP_MEMORY_LIMIT=256M
  export MYSQL_INNODB_BUFFER_POOL_SIZE=256M
  export REDIS_MEMORY_LIMIT=128mb
  export MAX_CONCURRENT_PROCESSES=2
  export NGINX_WORKER_PROCESSES=2
  export NGINX_WORKER_CONNECTIONS=512
else
  # Scale up for larger servers
  export PHP_MEMORY_LIMIT=512M
  export MYSQL_INNODB_BUFFER_POOL_SIZE=512M
  export REDIS_MEMORY_LIMIT=256mb
  export MAX_CONCURRENT_PROCESSES=4
  export NGINX_WORKER_PROCESSES=auto
  export NGINX_WORKER_CONNECTIONS=1024
fi

# Optionally write these to a .env file or source them in entrypoint scripts
# echo "PHP_MEMORY_LIMIT=$PHP_MEMORY_LIMIT" >> /var/azuracast/.env
# ...

echo "Memory-based limits set: PHP=$PHP_MEMORY_LIMIT, MySQL=$MYSQL_INNODB_BUFFER_POOL_SIZE, Redis=$REDIS_MEMORY_LIMIT"