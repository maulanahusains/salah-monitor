<script lang="ts" setup>
import BaseModal from '@/components/Base/BaseModal.vue';
import BaseFormInput from '../Base/BaseFormInput.vue';
import { ref, reactive, type Ref, type ComputedRef, computed } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import type { JenisType } from '@/interfaces';
import BaseButton from '../Base/BaseButton.vue';

const inputs: JenisType = reactive({
  jenisGerakan: '',
  perRakaat: 0
});

const rules: ComputedRef = computed(() => {
  return {
    jenisGerakan: { required },
    perRakaat: { required }
  };
});

const v$ = useVuelidate(rules, inputs);

const addData = () => {
  console.log('coba');
};
</script>

<template>
  <BaseModal title="Add Data">
    <template #body>
      <form action="" @submit.prevent="addData">
        <BaseFormInput
          label="Jenis Gerakan"
          id="jenis-gerakan"
          v-model="inputs.jenisGerakan"
          :validation="v$.jenisGerakan"
        />
        <BaseFormInput
          label="Poin Per Rakaat"
          id="poin-per-rakaat"
          v-model="inputs.perRakaat"
          :validation="v$.perRakaat"
        />
      </form>
    </template>
    <template #footer>
      <BaseButton color="secondary" @clicked="console.log('do nothing')" data-bs-dismiss="modal">
        Close
      </BaseButton>
      <BaseButton color="navy" @clicked="addData" data-bs-dismiss="modal">Save Changes</BaseButton>
    </template>
  </BaseModal>
</template>
