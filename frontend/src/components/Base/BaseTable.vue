<script lang="ts" setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import 'datatables.net-responsive';
import 'datatables.net-select';

DataTable.use(DataTablesCore);

const options = {
  responsive: true,
  select: true
};

defineProps({
  data: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <DataTable :options="options" :data="data" class="table table-bordered table-striped" />
</template>
