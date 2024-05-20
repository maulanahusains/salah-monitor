<script lang="ts" setup>
defineProps({
  shadow: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <div class="card" :class="{ 'border-0 shadow-sm': shadow == true }">
    <div class="card-body">
      <slot />
    </div>
  </div>
</template>
