<script lang="ts" setup>
defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'text'
  },
  modelValue: {
    type: String,
    default: ''
  },
  additionalClass: {
    type: String,
    default: ''
  },
  validation: {
    type: Object
  }
});
</script>

<template>
  <div class="form-group" :class="[additionalClass]">
    <label :for="id">{{ label }}</label>
    <input
      class="form-control"
      :id="id"
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <span v-for="error in validation.$errors" :key="error.$uid" class="text-danger">
      {{ error.$message }}
      <br />
    </span>
  </div>
</template>
