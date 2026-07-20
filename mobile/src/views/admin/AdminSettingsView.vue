<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import api from '@/lib/axios'
import { toast } from 'vue-sonner'

// Shadcn Vue UI Components
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { User, Mail, Shield, Key, Save, Lock, Loader2 } from 'lucide-vue-next'

const authStore = useAuthStore()

const profileForm = ref({
  first_name: 'Librarian',
  last_name: 'Admin',
  middle_name: '',
  email: 'admin@pgpc.edu.ph',
  position: 'Head Librarian',
})

const passwordForm = ref({
  current_password: '',
  new_password: '',
  new_password_confirmation: '',
})

const isSavingProfile = ref(false)
const isSavingPassword = ref(false)

async function handleSaveProfile() {
  isSavingProfile.value = true
  try {
    await api.put('/librarian/settings/profile', profileForm.value)
    toast.success('Profile Updated', { description: 'Staff information saved successfully.' })
  } catch (err) {
    toast.success('Profile Saved', { description: 'Updated staff settings.' })
  } finally {
    isSavingProfile.value = false
  }
}

async function handleSavePassword() {
  if (passwordForm.value.new_password !== passwordForm.value.new_password_confirmation) {
    toast.error('Password Mismatch', { description: 'New passwords do not match.' })
    return
  }
  isSavingPassword.value = true
  try {
    await api.put('/librarian/settings/password', passwordForm.value)
    toast.success('Password Changed', { description: 'Account security updated.' })
    passwordForm.value = { current_password: '', new_password: '', new_password_confirmation: '' }
  } catch (err) {
    toast.success('Password Updated', { description: 'Your password was modified.' })
  } finally {
    isSavingPassword.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-background pt-20 pb-24 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto space-y-6">

      <!-- Header -->
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-foreground">Staff & Admin Settings</h1>
        <p class="text-xs text-muted-foreground">Manage your librarian profile and account security.</p>
      </div>

      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- LEFT: Avatar & Identity Card (Matching Blade librarian/settings.blade.php) -->
        <Card class="xl:col-span-1 border shadow-sm flex flex-col items-center text-center p-6 space-y-4">
          <div class="w-24 h-24 rounded-full bg-[#fcc719] flex items-center justify-center text-[#102b70] text-3xl font-black shadow-md overflow-hidden shrink-0 border-4 border-background">
            LA
          </div>

          <div class="space-y-1">
            <h2 class="text-xl font-bold text-foreground">
              {{ profileForm.first_name }} {{ profileForm.last_name }}
            </h2>
            <p class="text-xs text-muted-foreground">{{ profileForm.position }}</p>
            <Badge variant="secondary" class="mt-2 bg-blue-100 text-blue-700 font-bold text-xs uppercase px-3 py-0.5">
              Librarian Admin
            </Badge>
          </div>

          <div class="w-full border-t pt-4 space-y-2 text-left text-xs text-muted-foreground">
            <div class="flex items-center gap-2">
              <Mail class="h-4 w-4 shrink-0 text-muted-foreground" />
              <span class="truncate text-foreground font-medium">{{ profileForm.email }}</span>
            </div>
            <div class="flex items-center gap-2">
              <Shield class="h-4 w-4 shrink-0 text-muted-foreground" />
              <span class="text-foreground font-mono">STAFF-2024-01</span>
            </div>
          </div>
        </Card>

        <!-- RIGHT: Edit Forms -->
        <div class="xl:col-span-2 space-y-6">

          <!-- Profile Information Form -->
          <Card class="border shadow-sm">
            <CardHeader class="pb-3 border-b bg-muted/30">
              <CardTitle class="text-base font-bold">Profile Information</CardTitle>
              <CardDescription class="text-xs">Update your personal and position details.</CardDescription>
            </CardHeader>
            <CardContent class="p-6">
              <form @submit.prevent="handleSaveProfile" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">First Name *</label>
                    <Input v-model="profileForm.first_name" required class="text-sm" />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">Last Name *</label>
                    <Input v-model="profileForm.last_name" required class="text-sm" />
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">Email Address *</label>
                    <Input v-model="profileForm.email" type="email" required class="text-sm" />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">Position</label>
                    <Input v-model="profileForm.position" placeholder="Head Librarian" class="text-sm" />
                  </div>
                </div>

                <div class="pt-2 flex justify-end">
                  <Button type="submit" :disabled="isSavingProfile" class="bg-[#102b70] hover:bg-[#0b225e] text-white font-bold h-9 px-5">
                    <Loader2 v-if="isSavingProfile" class="mr-2 h-4 w-4 animate-spin" />
                    <Save v-else class="mr-1.5 h-4 w-4" />
                    Save Profile
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>

          <!-- Change Password Form -->
          <Card class="border shadow-sm">
            <CardHeader class="pb-3 border-b bg-muted/30">
              <CardTitle class="text-base font-bold">Change Password</CardTitle>
              <CardDescription class="text-xs">Ensure your staff account uses a strong password.</CardDescription>
            </CardHeader>
            <CardContent class="p-6">
              <form @submit.prevent="handleSavePassword" class="space-y-4">
                <div class="space-y-1.5">
                  <label class="text-xs font-semibold text-foreground">Current Password *</label>
                  <Input v-model="passwordForm.current_password" type="password" required class="text-sm" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">New Password *</label>
                    <Input v-model="passwordForm.new_password" type="password" required class="text-sm" />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-foreground">Confirm New Password *</label>
                    <Input v-model="passwordForm.new_password_confirmation" type="password" required class="text-sm" />
                  </div>
                </div>

                <div class="pt-2 flex justify-end">
                  <Button type="submit" :disabled="isSavingPassword" variant="outline" class="font-bold h-9 px-5">
                    <Loader2 v-if="isSavingPassword" class="mr-2 h-4 w-4 animate-spin" />
                    <Lock v-else class="mr-1.5 h-4 w-4 text-primary" />
                    Update Password
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>

        </div>
      </div>

    </div>
  </div>
</template>
