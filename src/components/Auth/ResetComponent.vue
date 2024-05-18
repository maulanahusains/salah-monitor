<script lang="ts" setup>
import BaseCard from '@/components/Base/BaseCard.vue';
import BaseFormInput from '@/components/Base/BaseFormInput.vue';
import BaseButton from '@/components/Base/BaseButton.vue';
import { ref, reactive, computed, type ComputedRef } from 'vue';
import { useRouter } from 'vue-router';
import { required, sameAs } from '@vuelidate/validators';
import useVuelidate from '@vuelidate/core';
import type { ResetPassUser } from '@/interfaces';

const router = useRouter();
const isReseting = ref(false);
const creds: ResetPassUser = reactive({
  password: '',
  confirmPassword: '',
  oldPassword: ''
});

const rules: ComputedRef = computed(() => {
  return {
    password: { required },
    confirmPassword: { required, sameAs: sameAs(creds.password) },
    oldPassword: { required } // ntar ada sameAs dengan old Password
  };
});

const v$ = useVuelidate(rules, creds);
const reset = async () => {
  const result = await v$.value.$validate();
  isReseting.value = true;
  if (result) {
    setTimeout(() => {
      router.push({ name: 'home' });
    }, 3000);
    return;
  }
  isReseting.value = false;
  return;
};
</script>

<template>
  <BaseCard>
    <h3 class="card-title text-center">Reset Password</h3>
    <form action="" @submit.prevent="reset">
      <BaseFormInput
        type="password"
        id="old-password"
        label="Old Password"
        additional-class="mt-2"
        v-model="creds.oldPassword"
        :validation="v$.oldPassword"
      />
      <BaseFormInput
        type="password"
        id="new-password"
        label="New Password"
        additional-class="mt-2"
        v-model="creds.password"
        :validation="v$.password"
      />
      <BaseFormInput
        type="password"
        id="confirm-password"
        label="Confirm Password"
        additional-class="my-2"
        v-model="creds.confirmPassword"
        :validation="v$.confirmPassword"
      />
      <BaseButton
        type="submit"
        size="sm"
        color="navy"
        additional-class="w-100"
        @clicked="reset"
        :disabled="isReseting"
      >
        <span v-if="!isReseting">Reset</span>
        <div class="load" v-else>
          <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          <span class="visually-hidden">Loading...</span>
        </div>
      </BaseButton>
    </form>
  </BaseCard>
</template>
