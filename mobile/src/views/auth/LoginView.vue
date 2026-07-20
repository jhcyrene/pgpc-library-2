<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { toast } from 'vue-sonner'

// Shadcn UI Components
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Loader2, ArrowLeft, Lock, Mail } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const email = ref('')
const password = ref('')
const remember = ref(false)
const errorMessage = ref('')
const isLoading = ref(false)

const handleLogin = async () => {
  isLoading.value = true
  errorMessage.value = ''
  try {
    await authStore.login({ email: email.value, password: password.value }, 'student')
    toast.success('Welcome back!', { description: 'Successfully logged into Student Portal.' })
    router.push('/student/dashboard')
  } catch (err) {
    console.warn('Backend login response fallback mode:', err)
    errorMessage.value = err.response?.data?.message || err.message || 'Invalid credentials'
    toast.error('Login Failed', { description: errorMessage.value })
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-background flex flex-col justify-center py-10 px-4 sm:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md space-y-6">
      
      <!-- Logo Header -->
      <div class="text-center space-y-2">
        <div class="mx-auto w-14 h-14 rounded-2xl bg-[#102b70] flex items-center justify-center text-[#fcc719] font-black text-xl shadow-md">
          PG
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-foreground">
          Student Portal Login
        </h2>
        <p class="text-xs text-muted-foreground max-w-xs mx-auto">
          Search the library catalog, view borrowed materials & manage reservations.
        </p>
      </div>

      <!-- Login Card -->
      <Card class="border shadow-md">
        <CardContent class="pt-6">
          <div v-if="errorMessage" class="mb-4 p-3 rounded-lg bg-destructive/10 text-destructive text-xs font-medium border border-destructive/20">
            {{ errorMessage }}
          </div>

          <form class="space-y-4" @submit.prevent="handleLogin">
            <div class="space-y-1.5">
              <label for="email" class="text-xs font-semibold text-foreground">
                Student ID / Email
              </label>
              <div class="relative">
                <Mail class="w-4 h-4 absolute left-3 top-2.5 text-muted-foreground" />
                <Input
                  id="email"
                  v-model="email"
                  type="email"
                  required
                  placeholder="student@pgpc.edu.ph"
                  class="pl-9 text-sm"
                />
              </div>
            </div>

            <div class="space-y-1.5">
              <div class="flex items-center justify-between">
                <label for="password" class="text-xs font-semibold text-foreground">
                  Password
                </label>
                <RouterLink to="/forgot-password" class="text-[11px] font-medium text-primary hover:underline">
                  Forgot password?
                </RouterLink>
              </div>
              <div class="relative">
                <Lock class="w-4 h-4 absolute left-3 top-2.5 text-muted-foreground" />
                <Input
                  id="password"
                  v-model="password"
                  type="password"
                  required
                  placeholder="••••••••"
                  class="pl-9 text-sm"
                />
              </div>
            </div>

            <Button
              type="submit"
              :disabled="isLoading"
              class="w-full bg-[#102b70] hover:bg-[#0b225e] text-white font-bold h-10 shadow transition-all mt-2"
            >
              <Loader2 v-if="isLoading" class="mr-2 h-4 w-4 animate-spin" />
              {{ isLoading ? 'Signing in...' : 'Sign In to Portal' }}
            </Button>
          </form>

          <div class="mt-6 text-center text-xs text-muted-foreground flex items-center justify-between border-t pt-4">
            <RouterLink to="/opac" class="inline-flex items-center text-muted-foreground hover:text-foreground">
              <ArrowLeft class="w-3.5 h-3.5 mr-1" />
              Back to Catalog
            </RouterLink>
            <RouterLink to="/staff/login" class="font-semibold text-primary hover:underline">
              Staff / Admin Login
            </RouterLink>
          </div>
        </CardContent>
      </Card>
    </div>
  </div>
</template>
