import axios from 'axios'
import { Preferences } from '@capacitor/preferences'
import { getServerUrl } from '@/services/api'

// Create Axios Instance
const api = axios.create({
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  timeout: 15000,
})

// Dynamically set Base URL before every request
api.interceptors.request.use(
  async (config) => {
    const baseUrl = getServerUrl()
    // Combine base URL with API route prefix if missing
    if (!config.baseURL) {
      config.baseURL = baseUrl.endsWith('/api') ? baseUrl : `${baseUrl.replace(/\/+$/, '')}/api`
    }

    // Attach Sanctum Bearer Token from Capacitor Preferences
    const { value: token } = await Preferences.get({ key: 'auth_token' })
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// Response Interceptor for Global Error Handling
api.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      await Preferences.remove({ key: 'auth_token' })
      await Preferences.remove({ key: 'auth_user' })
      window.dispatchEvent(new CustomEvent('unauthorized-access'))
    }
    return Promise.reject(error)
  }
)

export default api
