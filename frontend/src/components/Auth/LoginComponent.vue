<script lang="ts" setup>
import BaseCard from '@/components/Base/BaseCard.vue';
import BaseFormInput from '@/components/Base/BaseFormInput.vue';
import BaseButton from '@/components/Base/BaseButton.vue';
import { ref, reactive, computed, type Ref, type ComputedRef } from 'vue';
import { useRouter, type Router } from 'vue-router';
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import type { User } from '@/interfaces';

const router: Router = useRouter();
const isLoggingIn: Ref<Boolean> = ref(false);
const creds: User = reactive({
  username: '',
  password: ''
});

const rules: ComputedRef = computed(() => {
  return {
    username: { required },
    password: { required }
  };
});

let v$ = useVuelidate(rules, creds);
const login: any = async () => {
  const result = await v$.value.$validate();
  isLoggingIn.value = true;
  if (result) {
    setTimeout(() => {
      router.push({ name: 'home' });
    }, 3000);
    return;
  }
  isLoggingIn.value = false;
  return;
};
</script>

<template>
  <BaseCard>
    <h3 class="card-title text-center">Login</h3>
    <form action="" @submit.prevent="login">
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
        v-model="creds.password"
        :validation="v$.password"
      />
      <BaseButton
        type="submit"
        size="sm"
        color="navy"
        additional-class="w-100 mt-2"
        @clicked="login"
        :disabled="isLoggingIn"
      >
        <span v-if="!isLoggingIn">Login</span>
        <div class="load" v-else>
          <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
          <span class="visually-hidden">Loading...</span>
        </div>
      </BaseButton>
    </form>
  </BaseCard>
</template>
