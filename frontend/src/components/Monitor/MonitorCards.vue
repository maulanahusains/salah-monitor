<script lang="ts" setup>
import BaseCard from '@/components/Base/BaseCard.vue';
import { ref } from 'vue';
import Coba from '../Base/coba.vue';
const cards = ref([
  {
    title: 'Mindfullness Shalat',
    subtitle: '90%',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16.5" height="22" viewBox="0 0 384 512"><path fill="white" d="M256 128c35.35 0 64-28.65 64-64S291.35 0 256 0s-64 28.65-64 64s28.65 64 64 64m-30.63 169.75c14.06 16.72 39 19.09 55.97 5.22l88-72.02c17.09-13.98 19.59-39.19 5.62-56.28c-13.97-17.11-39.19-19.59-56.31-5.62l-57.44 47l-38.91-46.31c-15.44-18.39-39.22-27.92-64-25.33c-24.19 2.48-45.25 16.27-56.37 36.92l-49.37 92.03c-23.4 43.64-8.69 96.37 34.19 123.75L131.56 432H40c-22.09 0-40 17.91-40 40s17.91 40 40 40h208c34.08 0 53.77-42.79 28.28-68.28L166.42 333.86l34.8-64.87z"/></svg>`
  },
  {
    title: 'Total Rakaat',
    subtitle: '40 rakaat',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="white" d="M12.79 21L3 11.21v2c0 .53.21 1.04.59 1.41l7.79 7.79c.78.78 2.05.78 2.83 0l6.21-6.21c.78-.78.78-2.05 0-2.83z"/><path fill="white" d="M11.38 17.41c.78.78 2.05.78 2.83 0l6.21-6.21c.78-.78.78-2.05 0-2.83L12.63.58A2.04 2.04 0 0 0 11.21 0H5C3.9 0 3 .9 3 2v6.21c0 .53.21 1.04.59 1.41zM7.25 3a1.25 1.25 0 1 1 0 2.5a1.25 1.25 0 0 1 0-2.5"/></svg>`
  }
]);
</script>

<template>
  <div class="col-lg-4">
    <div class="d-flex flex-column gap-4">
      <BaseCard :shadow="true" v-for="(item, index) in cards" :key="index">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex flex-column">
            <h3>{{ item.title }}</h3>
            <span>{{ item.subtitle }}</span>
          </div>
          <div class="p-4 bg-navy rounded shadow-sm" v-html="item.svg"></div>
        </div>
      </BaseCard>
    </div>
  </div>
</template>
