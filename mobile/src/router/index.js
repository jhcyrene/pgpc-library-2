import { createRouter, createWebHashHistory } from 'vue-router'

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'set-library',
      component: () => import('../views/SetLibraryView.vue'),
    },
  ],
})

export default router
