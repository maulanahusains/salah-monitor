import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('@/views/AboutView.vue')
    },
    {
      path: '/jenis',
      name: 'jenis',
      component: () => import('@/views/JenisView.vue')
    },
    {
      path: '/monitor',
      name: 'monitor',
      component: () => import('@/views/MonitorView.vue')
    },
    {
      path: '/auth',
      component: () => import('@/views/AuthView.vue'),
      children: [
        {
          path: '',
          name: 'default-login',
          component: () => import('@/components/Auth/LoginComponent.vue')
        },
        {
          path: 'login',
          name: 'login',
          component: () => import('@/components/Auth/LoginComponent.vue')
        },
        {
          path: 'register',
          name: 'register',
          component: () => import('@/components/Auth/RegisterComponent.vue')
        },
        {
          path: 'reset-password',
          name: 'reset-password', // ntar n ambah beforeEnter harus login dulu
          component: () => import('@/components/Auth/ResetComponent.vue')
        }
      ]
    }
  ]
});

export default router;
