<script setup>
import { computed, onMounted } from 'vue'
import { RouterView, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import { Toaster } from '@/components/ui/sonner'

const route = useRoute()
const authStore = useAuthStore()

const isFullscreenMobileRoute = computed(() => {
  return ['splash', 'set-library'].includes(route.name)
})

onMounted(() => {
  authStore.initializeAuth()
})
</script>

<template>
  <div class="min-h-screen flex flex-col font-sans bg-background text-foreground antialiased selection:bg-primary selection:text-primary-foreground">
    <!-- Top Bar -->
    <Navbar v-if="!isFullscreenMobileRoute" />

    <!-- Main Viewport -->
    <main class="flex-1 w-full">
      <RouterView />
    </main>

    <!-- Footer -->
    <Footer v-if="!isFullscreenMobileRoute" />

    <!-- Global Toast Notifications -->
    <Toaster />
  </div>
</template>
