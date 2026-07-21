<script setup>
import { onMounted } from 'vue'
import { RouterView } from 'vue-router'

import { App } from '@capacitor/app'
import { Capacitor } from '@capacitor/core'

onMounted(() => {
  // Hardware Back Button listener for Android/Native platform
  if (Capacitor.isNativePlatform()) {
    App.addListener('backButton', ({ canGoBack }) => {
      if (canGoBack || window.history.length > 1) {
        window.history.back()
      } else {
        App.exitApp()
      }
    })
  }
})
</script>

<template>
  <RouterView />
</template>
