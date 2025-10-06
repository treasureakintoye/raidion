<template>
  <button 
    @click="toggleTheme" 
    class="theme-toggle"
    :title="$gettext(isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode')"
    :aria-label="$gettext(isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode')"
  >
    <span class="sr-only">{{ $gettext(isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode') }}</span>
    <svg
      v-if="isDark"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      class="theme-toggle-icon"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
      />
    </svg>
    <svg
      v-else
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      class="theme-toggle-icon"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
      />
    </svg>
  </button>
</template>

<script setup lang="ts">
import {useTranslate} from "~/vendor/gettext";
import {useTheme} from "~/functions/theme";

const {$gettext} = useTranslate();
const {isDark, toggleTheme} = useTheme();
</script>

<style lang="scss" scoped>
.theme-toggle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2.5rem;
  height: 2.5rem;
  padding: 0.5rem;
  border: none;
  border-radius: 0.75rem;
  background: transparent;
  color: var(--bs-body-color);
  cursor: pointer;
  transition: all var(--duration-normal) var(--ease-in-out);

  &:hover {
    background: var(--surface-1);
    transform: scale(1.1);
  }

  &-icon {
    width: 1.5rem;
    height: 1.5rem;
    transition: transform var(--duration-normal) var(--spring-bounce);
  }

  &:hover &-icon {
    transform: rotate(15deg);
  }
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
</style>