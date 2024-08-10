<script setup lang="ts">
import BaseButton from '@/components/Base/BaseButton.vue';
import BaseCard from '@/components/Base/BaseCard.vue';
import BaseTable from '@/components/Base/BaseTable.vue';
import NavBar from '@/components/Layouts/NavBar.vue';
import ModalAddJenis from '@/components/Jenis/ModalAddJenis.vue';

const columns = [
  // ntar ganti id jadi dtrowindex
  { data: 'id', title: '#' },
  { data: 'nama_jenis', title: 'Nama Jenis' },
  { data: 'per_rakaat', title: 'Poin Per Rakaat' },
  { data: 'aksi', title: 'Aksi' }
];

const data = [
  {
    id: 1,
    nama_jenis: 'Berdiri',
    per_rakaat: 10,
    aksi: '<button>Hapus</button>'
  }
];
</script>

<template>
  <NavBar />
  <main class="px-4 py-2">
    <div class="row">
      <div class="col-lg-12">
        <BaseCard :shadow="true">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title">Jenis Gerakan</h4>
            <BaseButton :toggle-modal="true" modal-target="#coba" color="navy" size="sm">
              Tambah Data
            </BaseButton>
          </div>
          <BaseTable :columns="columns" :data="data" />
        </BaseCard>
      </div>
    </div>
  </main>

  <ModalAddJenis id="coba" />
</template>
