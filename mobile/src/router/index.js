import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'splash',
      component: () => import('../views/SplashScreenView.vue'),
    },
    {
      path: '/set-library',
      name: 'set-library',
      component: () => import('../views/SetLibraryView.vue'),
    },
    {
      path: '/opac',
      name: 'opac',
      component: () => import('../views/OpacView.vue'),
    },
    {
      path: '/opac/search',
      name: 'opac-search',
      component: () => import('../views/opac/OpacSearchView.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/LoginView.vue'),
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/RegisterView.vue'),
    },
    {
      path: '/forgot-password',
      name: 'forgot-password',
      component: () => import('../views/auth/ForgotPasswordView.vue'),
    },
    {
      path: '/otp',
      name: 'otp',
      component: () => import('../views/auth/OtpView.vue'),
    },
    {
      path: '/reset-password',
      name: 'reset-password',
      component: () => import('../views/auth/ResetPasswordView.vue'),
    },
    {
      path: '/staff/login',
      name: 'staff-login',
      component: () => import('../views/auth/StaffLoginView.vue'),
    },
    {
      path: '/student/dashboard',
      name: 'student-dashboard',
      component: () => import('../views/student/DashboardView.vue'),
    },
    {
      path: '/student/borrow-transactions',
      name: 'student-borrows',
      component: () => import('../views/student/BorrowTransactionsView.vue'),
    },
    {
      path: '/student/reservations',
      name: 'student-reservations',
      component: () => import('../views/student/ReservationsView.vue'),
    },
    {
      path: '/student/fines',
      name: 'student-fines',
      component: () => import('../views/student/FinesView.vue'),
    },
    {
      path: '/student/saved-items',
      name: 'student-saved-items',
      component: () => import('../views/student/SavedItemsView.vue'),
    },
    {
      path: '/student/profile',
      name: 'student-profile',
      component: () => import('../views/student/ProfileView.vue'),
    },
    {
      path: '/student/account-settings',
      name: 'student-account-settings',
      component: () => import('../views/student/AccountSettingsView.vue'),
    },
    {
      path: '/admin/dashboard',
      name: 'admin-dashboard',
      component: () => import('../views/admin/AdminDashboardView.vue'),
    },
    {
      path: '/admin/books',
      name: 'admin-books',
      component: () => import('../views/admin/BookManagerView.vue'),
    },
    {
      path: '/admin/books/add',
      name: 'admin-add-book',
      component: () => import('../views/admin/AddBookView.vue'),
    },
    {
      path: '/admin/settings',
      name: 'admin-settings',
      component: () => import('../views/admin/AdminSettingsView.vue'),
    },
  ],
})

export default router
