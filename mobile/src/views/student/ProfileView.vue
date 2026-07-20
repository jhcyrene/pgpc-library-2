<script setup>
import { ref, computed, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import api from '@/lib/axios'

// Shadcn Vue UI Components
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { User, ShieldCheck, Key, Edit, QrCode, Lock, CheckCircle2 } from 'lucide-vue-next'

const authStore = useAuthStore()
const profile = ref(null)
const isLoading = ref(true)

const userInitials = computed(() => {
  const u = authStore.user || profile.value || {}
  const first = u.first_name || u.name || 'S'
  const last = u.last_name || 'U'
  return `${first.charAt(0)}${last.charAt(0)}`.toUpperCase()
})

const studentName = computed(() => {
  const u = authStore.user || profile.value || {}
  if (u.first_name && u.last_name) return `${u.first_name} ${u.last_name}`
  return u.name || 'Student Member'
})

const studentId = computed(() => {
  const u = authStore.user || profile.value || {}
  return u.student_id_number || u.student_id || '2024-00123'
})

async function fetchProfile() {
  isLoading.value = true
  try {
    const res = await api.get('/student/profile')
    if (res.data) profile.value = res.data
  } catch (err) {
    console.warn('Profile fallback mode:', err)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchProfile()
})
</script>

<template>
  <div class="min-h-screen bg-background pt-20 pb-24 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto space-y-6">

      <!-- Title Header -->
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-black text-foreground tracking-tight">My Profile</h1>
      </div>

      <!-- User Information Header Card (Matching Blade show.blade.php with Watermark) -->
      <Card class="border shadow-sm relative overflow-hidden bg-card">
        <!-- Background Seal Watermark -->
        <img
          src="/images/hd-pgpc-logo.png"
          alt="Watermark"
          class="absolute -right-8 -bottom-8 w-56 h-56 opacity-[0.05] grayscale object-contain pointer-events-none"
        />

        <CardContent class="p-6 md:p-8 relative z-10">
          <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
              <!-- Avatar Circle -->
              <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-background shadow-md bg-[#102b70] text-[#fcc719] flex items-center justify-center shrink-0">
                <span class="text-3xl font-black">{{ userInitials }}</span>
              </div>

              <div class="space-y-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                  <h2 class="text-2xl font-black text-foreground leading-tight">{{ studentName }}</h2>
                  <Badge variant="secondary" class="bg-blue-100 text-[#102b70] font-bold text-xs px-3 py-0.5">
                    Student
                  </Badge>
                </div>
                <p class="text-sm font-semibold text-muted-foreground">{{ studentId }}</p>
              </div>
            </div>

            <Button as-child variant="outline" size="sm" class="h-9 px-4 text-xs font-bold gap-2">
              <RouterLink to="/student/account-settings">
                <Edit class="w-4 h-4 text-muted-foreground" />
                Edit Profile
              </RouterLink>
            </Button>
          </div>
        </CardContent>
      </Card>

      <!-- 3-Column / Grid Cards (Carbon Copy of Blade) -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- COLUMN 1: Personal Information -->
        <Card class="border shadow-sm flex flex-col justify-between">
          <CardHeader class="pb-3 border-b bg-muted/30">
            <CardTitle class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2 text-foreground">
              <User class="w-4 h-4 text-[#102b70]" />
              Personal Information
            </CardTitle>
          </CardHeader>
          <CardContent class="p-5 space-y-3.5 text-xs">
            <div class="flex justify-between items-center py-1">
              <span class="font-bold text-muted-foreground">First Name</span>
              <span class="font-bold text-foreground">{{ (authStore.user?.first_name) || 'Juan' }}</span>
            </div>
            <div class="flex justify-between items-center py-1 border-t border-border">
              <span class="font-bold text-muted-foreground">Last Name</span>
              <span class="font-bold text-foreground">{{ (authStore.user?.last_name) || 'Dela Cruz' }}</span>
            </div>
            <div class="flex justify-between items-start py-1 border-t border-border gap-2">
              <span class="font-bold text-muted-foreground shrink-0">Email Address</span>
              <span class="font-bold text-foreground text-right truncate max-w-[170px]">{{ authStore.user?.email || 'student@pgpc.edu.ph' }}</span>
            </div>
            <div class="flex justify-between items-center py-1 border-t border-border">
              <span class="font-bold text-muted-foreground">Student Number</span>
              <span class="font-bold text-foreground">{{ studentId }}</span>
            </div>
            <div class="flex justify-between items-start py-1 border-t border-border gap-2">
              <span class="font-bold text-muted-foreground shrink-0">Program / Course</span>
              <span class="font-bold text-foreground text-right leading-tight max-w-[170px]">BS Information Technology</span>
            </div>
            <div class="flex justify-between items-center py-1 border-t border-border">
              <span class="font-bold text-muted-foreground">Year Level</span>
              <span class="font-bold text-foreground">3rd Year</span>
            </div>
          </CardContent>
        </Card>

        <!-- COLUMN 2: Account & Security -->
        <Card class="border shadow-sm flex flex-col justify-between">
          <CardHeader class="pb-3 border-b bg-muted/30">
            <CardTitle class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2 text-foreground">
              <ShieldCheck class="w-4 h-4 text-[#102b70]" />
              Account & Security
            </CardTitle>
          </CardHeader>
          <CardContent class="p-5 space-y-4">
            <div class="flex justify-between items-center py-1 text-xs">
              <span class="font-bold text-muted-foreground">Linked Account</span>
              <Badge variant="secondary" class="bg-emerald-50 text-emerald-700 border-emerald-200 text-[11px] font-bold">
                <CheckCircle2 class="w-3.5 h-3.5 mr-1" />
                Active Student
              </Badge>
            </div>

            <!-- Change Password Button -->
            <RouterLink to="/student/account-settings" class="flex items-center justify-between p-3 rounded-xl border bg-muted/20 hover:bg-muted/40 transition-colors group">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                  <Key class="w-4 h-4" />
                </div>
                <div>
                  <p class="text-xs font-bold text-foreground group-hover:text-primary transition-colors">Change Password</p>
                  <p class="text-[10px] text-muted-foreground">Update your login security</p>
                </div>
              </div>
            </RouterLink>
          </CardContent>
        </Card>

        <!-- COLUMN 3: Digital Library Card -->
        <Card class="border shadow-sm flex flex-col justify-between bg-gradient-to-b from-card to-muted/30">
          <CardHeader class="pb-3 border-b bg-muted/30">
            <CardTitle class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2 text-foreground">
              <QrCode class="w-4 h-4 text-[#102b70]" />
              Digital Library Pass
            </CardTitle>
          </CardHeader>
          <CardContent class="p-5 flex flex-col items-center text-center space-y-3">
            <div class="w-32 h-32 bg-white border-2 border-[#102b70]/20 p-2 rounded-2xl flex items-center justify-center shadow-inner">
              <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PGPC-STUDENT-2024-00123"
                alt="Library QR Code"
                class="w-full h-full object-contain"
              />
            </div>
            <p class="text-xs font-mono font-bold text-primary">{{ studentId }}</p>
            <p class="text-[10px] text-muted-foreground">Scan at library entrance or checkout desk</p>
          </CardContent>
        </Card>

      </div>

    </div>
  </div>
</template>
