<script setup lang="ts">
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseCard from '@/components/Base/BaseCard.vue';
import BaseMultiChecks from '@/components/Base/BaseMultiChecks.vue';
import BaseTable from '@/components/Base/BaseTable.vue';
import NavBar from '@/components/Layouts/NavBar.vue';
import MonitorCards from '@/components/Monitor/MonitorCards.vue';
import ModalAddMonitor from '@/components/Monitor/ModalAddMonitor.vue';
import { reactive, type Ref, ref } from 'vue';

const collection: Ref = ref([]);
const data: Ref = ref([
  { nama_jenis: 'Berdiri', id: '1' },
  { nama_jenis: 'Duduk', id: '2' },
  { nama_jenis: 'Sujud', id: '3' },
  { nama_jenis: 'Tahiyat', id: '4' }
]);

const columns = [
  // ntar ganti id jadi dtrowindex
  { data: 'id', title: '#' },
  { data: 'nama_monitor', title: 'Name' },
  { data: 'nama_jenis', title: 'Movements' },
  { data: 'total_rakaat', title: 'Total Rakaat' },
  { data: 'total_point', title: 'Total Point' },
  { data: 'cek', title: 'Mindfullnes' },
  { data: 'aksi', title: 'Action' }
];

const datas = [
  {
    id: 1,
    nama_jenis: 'Berdiri',
    per_rakaat: 10,
    aksi: '<button class="btn btn-sm btn-outline-lavender">Delete</button> <button class="btn btn-sm btn-outline-lavender">Edit</button>'
  }
];
</script>

<template>
  <NavBar />
  <main class="mx-4 my-2">
    <BaseMultiChecks :options="data" v-model:value="collection" />
    <div class="row mt-4">
      <div class="col-lg-8">
        <BaseCard :shadow="true">
          <div class="d-flex align-items-center justify-content-between">
            <h3 class="card-title">Monitor</h3>
            <BaseButton :toggle-modal="true" modal-target="#add-monitor" color="navy" size="sm">
              Add Monitor
            </BaseButton>
          </div>
          <BaseTable :columns="columns" :data="datas" />
        </BaseCard>
      </div>
      <MonitorCards />
    </div>
  </main>

  <ModalAddMonitor id="add-monitor" />
</template>
