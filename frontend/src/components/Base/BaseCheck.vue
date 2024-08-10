<script lang="ts" setup>
defineProps({
  label: {
    type: String,
    default: ''
  },
  id: {
    type: String,
    default: ''
  },
  checked: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <input
    type="checkbox"
    class="btn-check"
    :checked="checked"
    @input="(event) => $emit('update:checked', event.target.checked)"
    :id="id"
  />
  <label class="btn btn-outline-navy" :for="id">{{ label }}</label>
</template>
