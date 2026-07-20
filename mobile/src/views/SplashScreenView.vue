<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { getServerUrl } from '@/services/api'

const router = useRouter()
const progress = ref(0)
const statusText = ref('Loading your library...')

onMounted(() => {
  const interval = setInterval(() => {
    progress.value += 12
    if (progress.value >= 100) {
      clearInterval(interval)
      const serverUrl = getServerUrl()
      if (serverUrl) {
        router.replace('/opac')
      } else {
        router.replace('/set-library')
      }
    }
  }, 180)
})
</script>

<template>
  <div class="fixed inset-0 bg-[#102b70] text-white flex flex-col items-center justify-between p-8 z-50 overflow-hidden font-sans select-none">
    <!-- Background Watermark -->
    <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
      <div class="w-[420px] h-[420px] rounded-full border-16 border-white flex items-center justify-center">
        <span class="text-9xl font-black text-white">PGPC</span>
      </div>
    </div>

    <!-- Top Spacer -->
    <div></div>

    <!-- Middle Logo & Brand (Matching Screen 1 Mockup) -->
    <div class="flex flex-col items-center text-center space-y-4 z-10">
      <div class="relative w-28 h-28 rounded-full border-4 border-[#fcc719] shadow-2xl bg-white flex items-center justify-center p-3">
        <!-- Emblem Logo -->
        <svg class="w-16 h-16 text-[#102b70]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
      </div>

      <div class="space-y-1">
        <h1 class="text-2xl font-black tracking-tight text-white">PGPC Library</h1>
        <p class="text-xs font-bold uppercase tracking-widest text-[#fcc719]">Mobile Access</p>
      </div>
    </div>

    <!-- Bottom Progress Indicator (Matching Screen 1 Mockup) -->
    <div class="w-full max-w-xs space-y-3 text-center z-10 pb-6">
      <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden">
        <div 
          class="bg-[#fcc719] h-full transition-all duration-200 rounded-full"
          :style="{ width: `${progress}%` }"
        ></div>
      </div>
      <p class="text-[11px] font-semibold text-blue-200/90">{{ statusText }}</p>
    </div>
  </div>
</template>
