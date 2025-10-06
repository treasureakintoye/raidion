import {Chart} from 'chart.js';

// Modern color palette
const colors = {
    primary: '#7C3AED',
    primaryLight: '#A78BFA',
    primaryDark: '#5B21B6',
    success: '#10B981',
    warning: '#F59E0B',
    danger: '#EF4444',
    gray: {
        100: '#F3F4F6',
        200: '#E5E7EB',
        300: '#D1D5DB',
        400: '#9CA3AF',
        500: '#6B7280'
    }
};

// Chart themes
export const modernChartTheme = {
    light: {
        backgroundColor: 'white',
        borderColor: colors.primary,
        pointBackgroundColor: colors.primary,
        pointBorderColor: 'white',
        pointHoverBackgroundColor: 'white',
        pointHoverBorderColor: colors.primary
    },
    dark: {
        backgroundColor: 'rgba(124, 58, 237, 0.1)',
        borderColor: colors.primary,
        pointBackgroundColor: colors.primary,
        pointBorderColor: '#1A1B23',
        pointHoverBackgroundColor: '#1A1B23',
        pointHoverBorderColor: colors.primary
    }
};

// Modern gradients
const createGradient = (ctx: CanvasRenderingContext2D, colors: string[]) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    colors.forEach((color, index) => {
        gradient.addColorStop(index / (colors.length - 1), color);
    });
    return gradient;
};

// Chart defaults
export const setModernChartDefaults = () => {
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
    Chart.defaults.font.size = 13;
    Chart.defaults.color = colors.gray[500];
    Chart.defaults.borderColor = colors.gray[200];
    
    // Line charts
    Chart.defaults.elements.line.tension = 0.4; // Smooth curves
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.line.fill = 'start';
    
    // Point styling
    Chart.defaults.elements.point.radius = 4;
    Chart.defaults.elements.point.hoverRadius = 6;
    
    // Bar charts
    Chart.defaults.elements.bar.borderRadius = 4;
    Chart.defaults.elements.bar.borderSkipped = false;
    
    // Tooltips
    Chart.defaults.plugins.tooltip.backgroundColor = 'white';
    Chart.defaults.plugins.tooltip.titleColor = colors.gray[500];
    Chart.defaults.plugins.tooltip.bodyColor = '#000';
    Chart.defaults.plugins.tooltip.borderColor = colors.gray[200];
    Chart.defaults.plugins.tooltip.borderWidth = 1;
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.boxPadding = 6;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    
    // Axes
    Chart.defaults.scales.linear.grid.color = colors.gray[200];
    Chart.defaults.scales.linear.grid.drawBorder = false;
    Chart.defaults.scales.linear.ticks.padding = 8;
    
    Chart.defaults.scales.category.grid.display = false;
};

// Custom chart gradient generator
export const getChartGradient = (ctx: CanvasRenderingContext2D, isDark = false) => {
    return createGradient(ctx, [
        isDark ? 'rgba(124, 58, 237, 0.2)' : 'rgba(124, 58, 237, 0.1)',
        isDark ? 'rgba(124, 58, 237, 0)' : 'rgba(124, 58, 237, 0)'
    ]);
};