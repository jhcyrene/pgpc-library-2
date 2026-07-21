<script setup>
import { ref } from 'vue'
import pgpcLogoFile from '@/assets/images/hd-pgpc-logo.webp'
import { Globe, X, Play, AlertCircle } from 'lucide-vue-next'

const inputUrl = ref('')
const errorMessage = ref('')

const normalizeUrl = (raw) => {
  const value = raw.trim()
  if (!value) throw new Error('Please enter an IP address or URL.')
  const hasProtocol = /^[a-zA-Z][a-zA-Z\d+\-.]*:/.test(value)
  const full = hasProtocol ? value : `http://${value}`
  const parsed = new URL(full)
  if (!['http:', 'https:'].includes(parsed.protocol))
    throw new Error('Only HTTP and HTTPS are allowed.')
  if (!parsed.hostname)
    throw new Error('Enter a valid hostname or IP address.')
  return parsed.toString()
}

const connect = () => {
  errorMessage.value = ''

  let url
  try {
    url = normalizeUrl(inputUrl.value)
  } catch (e) {
    errorMessage.value = e.message
    return
  }

  // Navigate — use href (not replace) so Android back button returns here
  window.location.href = url
}

const clearInput = () => {
  inputUrl.value = ''
  errorMessage.value = ''
}
</script>

<template>
  <div class="fixed inset-0 flex flex-col items-center justify-center bg-[#07132b] px-6 font-sans text-white">

    <!-- Watermark -->
    <div class="pointer-events-none absolute inset-0 flex items-center justify-center opacity-5">
      <img :src="pgpcLogoFile" alt="" class="w-96 h-96 object-contain grayscale" />
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-sm space-y-6">

      <!-- Logo -->
      <div class="flex flex-col items-center space-y-3">
        <div class="relative">
          <div class="flex size-24 items-center justify-center rounded-full border-4 border-[#fcc719] bg-white p-2 shadow-2xl">
            <img :src="pgpcLogoFile" alt="PGPC Logo" class="size-full object-contain" />
          </div>
          <div aria-hidden="true" class="absolute -inset-2 rounded-full border-2 border-dashed border-[#fcc719]/50 animate-spin" style="animation-duration:10s" />
        </div>
        <div class="text-center">
          <h1 class="text-2xl font-black tracking-tight">
            PGPC Library <span class="text-[#fcc719]">System</span>
          </h1>
          <p class="mt-1 text-xs text-slate-400">Enter your server address to connect</p>
        </div>
      </div>

      <!-- Input Form -->
      <form @submit.prevent="connect" novalidate class="space-y-3">

        <!-- URL Input -->
        <div
          class="flex items-center rounded-2xl border border-white/20 bg-slate-900 p-1.5 shadow-inner transition-all focus-within:border-[#fcc719] focus-within:ring-2 focus-within:ring-[#fcc719]/20"
        >
          <Globe class="ml-2.5 size-5 shrink-0 text-slate-400" aria-hidden="true" />

          <input
            v-model="inputUrl"
            type="text"
            inputmode="url"
            autocomplete="url"
            autocapitalize="none"
            spellcheck="false"
            placeholder="192.168.1.40:8000"
            aria-label="Server URL"
            class="min-w-0 flex-1 bg-transparent px-3 py-3 font-mono text-sm text-white placeholder:text-slate-500 focus:outline-none"
            @input="errorMessage = ''"
          />

          <button
            v-if="inputUrl"
            type="button"
            aria-label="Clear"
            class="mr-1 shrink-0 rounded-full bg-white/10 p-1.5 text-slate-400 transition hover:text-white"
            @click="clearInput"
          >
            <X class="size-4" aria-hidden="true" />
          </button>
        </div>

        <!-- Error -->
        <p v-if="errorMessage" role="alert" class="flex items-center gap-1.5 text-xs font-semibold text-rose-400">
          <AlertCircle class="size-3.5 shrink-0" aria-hidden="true" />
          {{ errorMessage }}
        </p>

        <!-- Connect Button -->
        <button
          type="submit"
          :disabled="!inputUrl.trim()"
          class="flex w-full items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-[#fcc719] to-amber-500 px-6 py-4 text-base font-black text-slate-950 shadow-xl transition-all hover:from-amber-400 hover:to-amber-600 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-40"
        >
          <Play class="size-5 fill-slate-950" aria-hidden="true" />
          Connect to Server
        </button>
      </form>

      <!-- Helper text -->
      <p class="text-center text-[11px] text-slate-500">
        Make sure your phone and PC are on the same Wi-Fi network.<br/>
        Press Android <strong class="text-slate-400">back</strong> to return here if the server is unreachable.
      </p>
    </div>
  </div>
</template>
