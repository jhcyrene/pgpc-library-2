import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { Preferences } from '@capacitor/preferences'
import api from '@/lib/axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)
  const userType = ref(null) // 'student' | 'staff' | 'admin'
  const isLoading = ref(false)

  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const isStudent = computed(() => userType.value === 'student')
  const isStaff = computed(() => userType.value === 'staff' || userType.value === 'admin')
  const isAdmin = computed(() => userType.value === 'admin')

  async function initializeAuth() {
    isLoading.value = true
    try {
      const { value: storedToken } = await Preferences.get({ key: 'auth_token' })
      const { value: storedUser } = await Preferences.get({ key: 'auth_user' })
      const { value: storedRole } = await Preferences.get({ key: 'auth_type' })

      if (storedToken) {
        token.value = storedToken
        if (storedUser) {
          user.value = JSON.parse(storedUser)
        }
        if (storedRole) {
          userType.value = storedRole
        }
        // Verify token with backend
        await fetchUser()
      }
    } catch (e) {
      console.warn('Auth initialization failed:', e)
      await logout()
    } finally {
      isLoading.value = false
    }
  }

  async function login(credentials, type = 'student') {
    isLoading.value = true
    try {
      const endpoint = type === 'staff' || type === 'admin' ? '/staff/login' : '/login'
      const response = await api.post(endpoint, {
        ...credentials,
        device_name: 'PGLibSystem Capacitor Mobile App',
      })

      const apiToken = response.data.token || response.data.access_token
      const userData = response.data.user || response.data.member || response.data

      token.value = apiToken
      user.value = userData
      userType.value = type

      await Preferences.set({ key: 'auth_token', value: apiToken })
      await Preferences.set({ key: 'auth_user', value: JSON.stringify(userData) })
      await Preferences.set({ key: 'auth_type', value: type })

      return response.data
    } finally {
      isLoading.value = false
    }
  }

  async function fetchUser() {
    try {
      const endpoint = userType.value === 'staff' || userType.value === 'admin' ? '/staff/user' : '/user'
      const response = await api.get(endpoint)
      user.value = response.data
      await Preferences.set({ key: 'auth_user', value: JSON.stringify(response.data) })
    } catch (error) {
      if (error.response?.status === 401) {
        await logout()
      }
    }
  }

  async function logout() {
    if (token.value) {
      try {
        const endpoint = userType.value === 'staff' || userType.value === 'admin' ? '/staff/logout' : '/logout'
        await api.post(endpoint)
      } catch (e) {
        // Ignore network failure on logout
      }
    }
    token.value = null
    user.value = null
    userType.value = null

    await Preferences.remove({ key: 'auth_token' })
    await Preferences.remove({ key: 'auth_user' })
    await Preferences.remove({ key: 'auth_type' })
  }

  return {
    user,
    token,
    userType,
    isLoading,
    isAuthenticated,
    isStudent,
    isStaff,
    isAdmin,
    initializeAuth,
    login,
    logout,
    fetchUser,
  }
})
