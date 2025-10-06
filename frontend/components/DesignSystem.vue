<template>
  <div class="design-system">
    <section class="design-section">
      <h2 class="heading-2">Typography</h2>
      <div class="design-showcase">
        <h1 class="heading-1">Heading 1</h1>
        <h2 class="heading-2">Heading 2</h2>
        <h3 class="heading-3">Heading 3</h3>
        <p class="body-large">Body Large</p>
        <p class="body">Body Text</p>
        <p class="body-small">Body Small</p>
        <code class="mono">Monospace Text</code>
      </div>
    </section>

    <section class="design-section">
      <h2 class="heading-2">Colors</h2>
      <div class="design-showcase color-grid">
        <div class="color-item">
          <div class="color-swatch bg-primary"></div>
          <p>Primary<br>#7C3AED</p>
        </div>
        <div class="color-item">
          <div class="color-swatch bg-primary-light"></div>
          <p>Primary Light<br>#A78BFA</p>
        </div>
        <div class="color-item">
          <div class="color-swatch bg-primary-dark"></div>
          <p>Primary Dark<br>#5B21B6</p>
        </div>
        <div class="color-item">
          <div class="color-swatch bg-surface-0"></div>
          <p>Surface 0</p>
        </div>
        <div class="color-item">
          <div class="color-swatch bg-surface-1"></div>
          <p>Surface 1</p>
        </div>
        <div class="color-item">
          <div class="color-swatch bg-surface-2"></div>
          <p>Surface 2</p>
        </div>
      </div>
    </section>

    <section class="design-section">
      <h2 class="heading-2">Components</h2>
      
      <h3 class="heading-3">Buttons</h3>
      <div class="design-showcase">
        <button class="btn btn-primary">Primary Button</button>
        <button class="btn btn-secondary">Secondary Button</button>
        <button class="btn btn-outline-primary">Outline Button</button>
      </div>

      <h3 class="heading-3">Cards</h3>
      <div class="design-showcase">
        <div class="card">
          <div class="card-header">
            <h4>Card Title</h4>
          </div>
          <div class="card-body">
            Card content goes here
          </div>
        </div>
      </div>

      <h3 class="heading-3">Forms</h3>
      <div class="design-showcase">
        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" placeholder="Label">
          <label for="floatingInput">Floating Label</label>
        </div>
        
        <div class="form-switch">
          <input type="checkbox" id="switch">
          <label for="switch">Toggle Switch</label>
        </div>
      </div>
    </section>

    <section class="design-section">
      <h2 class="heading-2">Charts</h2>
      <div class="design-showcase">
        <div class="card">
          <div class="card-body">
            <time-series-chart
              style="width: 100%"
              :data="sampleChartData"
              :aspect-ratio="3"
            />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import TimeSeriesChart from '~/components/Common/Charts/TimeSeriesChart.vue';
import {ref} from 'vue';

// Sample data for the chart
const sampleChartData = ref([{
  label: 'Sample Data',
  data: [
    {x: Date.now() - 86400000 * 6, y: 10},
    {x: Date.now() - 86400000 * 5, y: 25},
    {x: Date.now() - 86400000 * 4, y: 15},
    {x: Date.now() - 86400000 * 3, y: 30},
    {x: Date.now() - 86400000 * 2, y: 20},
    {x: Date.now() - 86400000, y: 35},
    {x: Date.now(), y: 25},
  ]
}]);
</script>

<style lang="scss" scoped>
.design-system {
  padding: 2rem;
  
  .design-section {
    margin-bottom: 3rem;
    
    h2 {
      margin-bottom: 1.5rem;
    }
  }
  
  .design-showcase {
    background: var(--surface-1);
    border-radius: var(--bento-border-radius);
    padding: 2rem;
    
    > * + * {
      margin-top: 1rem;
    }
  }
  
  .color-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    
    .color-item {
      text-align: center;
      
      .color-swatch {
        width: 100%;
        height: 80px;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
      }
    }
  }
}

// Color utility classes for the showcase
.bg-primary {
  background-color: var(--primary);
}
.bg-primary-light {
  background-color: var(--primary-light);
}
.bg-primary-dark {
  background-color: var(--primary-dark);
}
.bg-surface-0 {
  background-color: var(--surface-0);
}
.bg-surface-1 {
  background-color: var(--surface-1);
}
.bg-surface-2 {
  background-color: var(--surface-2);
}
</style>