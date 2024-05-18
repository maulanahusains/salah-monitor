<script lang="ts" setup>
defineProps({
  type: {
    default: 'button'
  },
  size: {
    type: String,
    default: 'md'
  },
  color: {
    type: String,
    default: 'primary'
  },
  additionalClass: {
    type: String,
    default: ''
  }
});
</script>

<template>
  <button
    class="btn"
    :type="type"
    :class="[`btn-${size}`, `btn-${color}`, additionalClass]"
    @click.prevent="$emit('clicked', $event)"
  >
    <slot />
  </button>
</template>
