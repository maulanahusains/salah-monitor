<script lang="ts" setup>
const props = defineProps({
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
  },
  inputGroupText: {
    type: String,
    required: true
  },
  isDisabled: {
    type: Boolean,
    default: false
  }
});
</script>

<template>
  <div class="form-group" :class="[additionalClass]">
    <label :for="id">{{ label }}</label>
    <div class="input-group mb-3">
      <input
        class="form-control"
        :id="id"
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :disabled="isDisabled"
      />
      <div class="input-group-append">
        <span class="input-group-text">{{ inputGroupText }}</span>
      </div>
    </div>
    <span v-for="error in validation.$errors" :key="error.$uid" class="text-danger">
      {{ error.$message }}
      <br />
    </span>
  </div>
</template>
