<script lang="ts" setup>
import { computed, reactive } from 'vue';
import BaseFormInput from '../Base/BaseFormInput.vue';
import BaseModal from '../Base/BaseModal.vue';
import BaseButton from '../Base/BaseButton.vue';
import { required, numeric } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';

defineProps({
  id: {
    type: String,
    required: true
  }
});

const form = reactive({
  name: '',
  jenis: [],
  totalRakaat: 0,
  gagal: 0,
  sukses: 0,
  inPercent: 0
});

const rules = computed(() => {
  return {
    name: { required },
    jenis: { required },
    totalRakaat: { required, numeric },
    gagal: { required },
    sukses: { required },
    inPercent: { required, numeric }
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
        <BaseFormInput
          additional-class="mb-2"
          id="jenis"
          label="Jenis Gerakan"
          v-model="form.jenis"
          :validation="v$.jenis"
        />
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
        <BaseFormInput
          additional-class="mb-2"
          type="number"
          id="persentase"
          label="Mindfullness"
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
