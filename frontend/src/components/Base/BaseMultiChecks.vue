<script lang="ts" setup>
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseCheckbox from '@/components/Base/BaseCheck.vue';
import { defineEmits } from 'vue';

const emit = defineEmits('update:value');
const props = defineProps({
  options: {
    type: Array,
    required: true
  },
  value: {
    type: Array
  }
});

const check = (optionId, checked) => {
  let updatedValue = [...props.value];

  if (checked) {
    updatedValue.push(optionId);
  } else {
    updatedValue.splice(updatedValue.indexOf(optionId), 1);
  }
  emit('update:value', updatedValue);
};
</script>
<template>
  <div
    class="my-2 container mx-auto d-flex flex-wrap align-items-center justify-content-center gap-2"
  >
    <BaseCheckbox
      v-for="option in options"
      :key="option"
      :label="option.nama_jenis"
      :id="option.id"
      :checked="value.includes(option.id)"
      @update:checked="check(option.id, $event)"
    />

    <BaseButton
      color="navy"
      data-bs-toggle="tooltip"
      data-bs-placement="top"
      data-bs-title="Tooltip on top"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="icon icon-tabler icons-tabler-outline icon-tabler-reload"
      >
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
        <path d="M20 4v5h-5" />
      </svg>
    </BaseButton>
  </div>
</template>
