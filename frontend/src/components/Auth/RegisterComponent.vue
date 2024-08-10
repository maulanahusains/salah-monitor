<script lang="ts" setup>
import BaseCard from '@/components/Base/BaseCard.vue';
import BaseFormInput from '@/components/Base/BaseFormInput.vue';
import BaseButton from '@/components/Base/BaseButton.vue';
import { ref, reactive, computed, type Ref, type ComputedRef } from 'vue';
import { useRouter, type Router } from 'vue-router';
import useVuelidate from '@vuelidate/core';
import { required, sameAs } from '@vuelidate/validators';
import type { RegistUser } from '@/interfaces';

const router: Router = useRouter();
const isRegistering: Ref<Boolean> = ref(false);
const creds: RegistUser = reactive({
  username: '',
  password: '',
  confirmPassword: ''
});

const rules: ComputedRef = computed(() => {
  return {
    username: { required },
    password: { required },
    confirmPassword: { required, sameAs: sameAs(creds.password) }
  };
});

const v$ = useVuelidate(rules, creds);

const register = async () => {
  const result = await v$.value.$validate();
  if (result) {
    isRegistering.value = true;
    setTimeout(() => {
      router.push({ name: 'home' });
    }, 3000);
    return;
  }
  isRegistering.value = false;
  return;
};
</script>

<template>
  <BaseCard>
    <h3 class="card-title text-center">Register</h3>
    <form action="" @submit.prevent="register">
      <BaseFormInput
        type="text"
        id="username"
        label="Username"
        v-model="creds.username"
        :validation="v$.username"
      />
      <BaseFormInput
        type="password"
        id="password"
        label="Password"
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
        @clicked="register"
        :disabled="isRegistering"
      >
        <span v-if="!isRegistering">Register</span>
        <div class="load" v-else>
          <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          <span class="visually-hidden">Loading...</span>
        </div>
      </BaseButton>
    </form>
  </BaseCard>
</template>
