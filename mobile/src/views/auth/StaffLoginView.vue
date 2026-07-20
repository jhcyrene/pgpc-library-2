<script setup>
import { ref } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { toast } from 'vue-sonner'

// Shadcn UI Components
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Loader2, ArrowLeft, Shield, Lock, User } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const isLoading = ref(false)
const errorMessage = ref('')

const handleStaffLogin = async () => {
  isLoading.value = true
  errorMessage.value = ''
  try {
    await authStore.login({ email: email.value, password: password.value }, 'staff')
    toast.success('Staff Authentication Successful', { description: 'Access granted to Library Management System.' })
    router.push('/admin/dashboard')
  } catch (err) {
    console.warn('Staff login fallback mode:', err)
    errorMessage.value = err.response?.data?.message || 'Invalid staff credentials'
    toast.error('Staff Login Failed', { description: errorMessage.value })
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-10 px-4 sm:px-6 text-slate-100">
    <div class="sm:mx-auto sm:w-full sm:max-w-md space-y-6">
      
      <!-- Logo & Header -->
      <div class="text-center space-y-2">
        <div class="mx-auto w-14 h-14 rounded-2xl bg-[#102b70] border border-slate-700 flex items-center justify-center text-[#fcc719] shadow-lg">
          <Shield class="w-7 h-7" />
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-white">
          Staff & Admin Portal
        </h2>
        <p class="text-xs text-slate-400 max-w-xs mx-auto">
          Authorized library system access for MARC catalog management & circulation controls.
        </p>
      </div>

      <!-- Login Card -->
      <Card class="border-slate-800 bg-slate-900 text-slate-100 shadow-xl">
        <CardContent class="pt-6">
          <div v-if="errorMessage" class="mb-4 p-3 rounded-lg bg-red-950/50 text-red-300 text-xs font-medium border border-red-800/40">
            {{ errorMessage }}
          </div>

          <form @submit.prevent="handleStaffLogin" class="space-y-4">
            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Staff Username / Email</label>
              <div class="relative">
                <User class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" />
                <Input
                  v-model="email"
                  type="text"
                  required
                  placeholder="admin@pgpc.edu.ph"
                  class="pl-9 bg-slate-950 border-slate-800 text-white placeholder-slate-500 focus-visible:ring-[#fcc719] text-sm"
                />
              </div>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Password</label>
              <div class="relative">
                <Lock class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" />
                <Input
                  v-model="password"
                  type="password"
                  required
                  placeholder="••••••••"
                  class="pl-9 bg-slate-950 border-slate-800 text-white placeholder-slate-500 focus-visible:ring-[#fcc719] text-sm"
                />
              </div>
            </div>

            <Button
              type="submit"
              :disabled="isLoading"
              class="w-full bg-[#fcc719] hover:bg-[#ffd84c] text-[#102b70] font-black h-10 shadow transition-all mt-2"
            >
              <Loader2 v-if="isLoading" class="mr-2 h-4 w-4 animate-spin text-[#102b70]" />
              {{ isLoading ? 'Authenticating...' : 'Sign In as Administrator' }}
            </Button>
          </form>

          <div class="mt-6 text-center text-xs text-slate-400 border-t border-slate-800 pt-4">
            <RouterLink to="/login" class="inline-flex items-center text-slate-400 hover:text-white">
              <ArrowLeft class="w-3.5 h-3.5 mr-1" />
              Switch to Student Portal Login
            </RouterLink>
          </div>
        </CardContent>
      </Card>
    </div>
  </div>
</template>
