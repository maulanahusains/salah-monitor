<script lang="ts" setup>
import { computed, reactive, watch } from 'vue';
import BaseFormInput from '../Base/BaseFormInput.vue';
import BaseModal from '../Base/BaseModal.vue';
import BaseButton from '../Base/BaseButton.vue';
import { required, numeric } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';
import Multiselect from 'vue-multiselect';
import BaseInputGroup from '@/components/Base/BaseInputGroup.vue';

defineProps({
  id: {
    type: String,
    required: true
  }
});

const options = [
  {
    id: 1,
    nama_jenis: 'Berdiri',
    per_rakaat: 10
  },
  {
    id: 2,
    nama_jenis: 'Duduk',
    per_rakaat: 5
  }
];

const form = reactive({
  name: '',
  jenis: [],
  totalRakaat: 0,
  gagal: 0,
  sukses: 0,
  inPercent: ''
});

// todo: tambahin watch untuk input gagal, sukses, inPercent dan sesuaikan ketiganya

const getTotalPoin = (): Number => {
  const totalPerRakaat =
    form.jenis.length > 1
      ? form.jenis.reduce((prev: never, next: never) => prev.per_rakaat + next.per_rakaat)
      : form.jenis[0].per_rakaat;

  const totalPoin = totalPerRakaat * form.totalRakaat;
  return totalPoin;
};

const isInvalid = (): Boolean => {
  if (form.jenis.length < 1) {
    return true;
  }

  if (form.totalRakaat <= 0) {
    form.gagal = 0;
    form.sukses = 0;
    form.inPercent = '';
    return true;
  }

  return false;
};

watch([() => form.gagal, () => form.totalRakaat, () => form.jenis], () => {
  const invalid = isInvalid();

  if (invalid) {
    return;
  }

  const totalPoin: any = getTotalPoin();
  const totalWithGagal = totalPoin - form.gagal;
  const mindfullness = (totalWithGagal / totalPoin) * 100;

  form.inPercent = mindfullness.toFixed(2);
  form.sukses = totalWithGagal;
});

watch(
  () => form.sukses,
  () => {
    const invalid = isInvalid();

    if (invalid) {
      return;
    }

    const totalPoin: any = getTotalPoin();
    const gagal = totalPoin - form.sukses;
    const mindfullness = (form.sukses / totalPoin) * 100;

    form.inPercent = mindfullness.toFixed(2);
    form.gagal = gagal;
  }
);

const rules = computed(() => {
  return {
    name: { required },
    jenis: { required },
    totalRakaat: { required, numeric },
    gagal: { required },
    sukses: { required },
    inPercent: { required }
  };
});

const v$ = useVuelidate(rules, form);
</script>

<template>
  <BaseModal :id="id" title="Add Monitor">
    <template #body>
      <form action="">
        <BaseFormInput
          additional-class="mb-2"
          id="shalat-name"
          label="Shalat Name"
          v-model="form.name"
          :validation="v$.name"
        />
        <div class="form-group">
          <label class="form-label">Jenis Gerakan</label>
          <multiselect
            v-model="form.jenis"
            tag-placeholder="Tambah Jenis"
            placeholder="Search jenis"
            label="nama_jenis"
            track-by="id"
            :options="options"
            :multiple="true"
            :taggable="false"
          ></multiselect>
        </div>
        <BaseFormInput
          additional-class="mb-2"
          type="number"
          id="total-rakaat"
          label="Total Rakaat"
          v-model="form.totalRakaat"
          :validation="v$.totalRakaat"
        />
        <div class="d-flex align-items-center justify-content-between">
          <BaseFormInput
            additional-class="mb-2"
            type="number"
            id="gagal"
            label="Gagal"
            v-model="form.gagal"
            :validation="v$.gagal"
          />
          <BaseFormInput
            additional-class="mb-2"
            type="number"
            id="sukses"
            label="Sukses"
            v-model="form.sukses"
            :validation="v$.sukses"
          />
        </div>
        <BaseInputGroup
          id="in-percent"
          label="Mindfullness"
          input-group-text="%"
          :is-disabled="true"
          v-model="form.inPercent"
          :validation="v$.inPercent"
        />
      </form>
    </template>
    <template #footer>
      <BaseButton
        color="outline-secondary"
        @clicked="console.log('do nothing')"
        data-bs-dismiss="modal"
      >
        Close
      </BaseButton>
      <BaseButton color="outline-navy" @clicked="console.log('coba')" data-bs-dismiss="modal">
        Save Changes
      </BaseButton>
    </template>
  </BaseModal>
</template>
