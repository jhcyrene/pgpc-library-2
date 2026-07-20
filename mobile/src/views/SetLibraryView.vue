<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { getServerUrl, setServerUrl, getDefaultServerUrl, fetchApi } from '@/services/api'
import { toast } from 'vue-sonner'

// Shadcn Vue components
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Globe, Link as LinkIcon, ShieldCheck, X, BookOpen, Loader2 } from 'lucide-vue-next'

const router = useRouter()
const inputUrl = ref('')
const loading = ref(false)
const errorMessage = ref('')

onMounted(() => {
  inputUrl.value = getServerUrl()
})

const handleConnect = async () => {
  if (!inputUrl.value.trim()) {
    errorMessage.value = 'Please enter a valid website URL.'
    return
  }

  loading.value = true
  errorMessage.value = ''

  const formattedUrl = setServerUrl(inputUrl.value)

  try {
    const res = await fetchApi('/api/opac/books?limit=1')
    toast.success('Connected to Library Server', { description: `Configured endpoint: ${formattedUrl}` })
    router.push('/opac')
  } catch (err) {
    // Proceed to catalog fallback
    toast.info('Saved Library Endpoint', { description: `Using ${formattedUrl}` })
    router.push('/opac')
  } finally {
    loading.value = false
  }
}

const useDefault = () => {
  const defaultUrl = getDefaultServerUrl()
  inputUrl.value = defaultUrl
  setServerUrl(defaultUrl)
  toast.success('Using Default Endpoint', { description: defaultUrl })
  router.push('/opac')
}

const clearInput = () => {
  inputUrl.value = ''
}
</script>

<template>
  <div class="min-h-screen bg-background flex flex-col justify-between p-6 sm:p-8 font-sans max-w-md mx-auto">
    <div></div>

    <div class="flex flex-col items-center text-center space-y-6">
      <!-- Icon Emblem -->
      <div class="w-20 h-20 rounded-3xl bg-primary/10 border border-primary/20 flex items-center justify-center relative shadow-sm">
        <BookOpen class="w-10 h-10 text-primary" />
        <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-[#102b70] text-[#fcc719] flex items-center justify-center border-2 border-background shadow-sm">
          <LinkIcon class="w-4 h-4" />
        </div>
      </div>

      <!-- Header -->
      <div class="space-y-1 max-w-xs">
        <h2 class="text-2xl font-bold tracking-tight text-foreground">Set Library Endpoint</h2>
        <p class="text-xs text-muted-foreground">
          Enter your Laravel 13 server domain or local IP address to connect the mobile app.
        </p>
      </div>

      <!-- Form Card -->
      <Card class="w-full border shadow-sm">
        <CardContent class="p-5 space-y-4">
          <div class="space-y-1.5 text-left">
            <label class="text-xs font-semibold text-foreground">Library Server URL</label>
            <div class="relative">
              <Globe class="w-4 h-4 absolute left-3 top-2.5 text-muted-foreground" />
              <Input
                v-model="inputUrl"
                type="url"
                placeholder="http://127.0.0.1:8000"
                class="pl-9 pr-8 text-xs font-mono"
                @keyup.enter="handleConnect"
              />
              <button
                v-if="inputUrl"
                type="button"
                @click="clearInput"
                class="absolute right-2.5 top-2.5 text-muted-foreground hover:text-foreground"
              >
                <X class="w-4 h-4" />
              </button>
            </div>
          </div>

          <p v-if="errorMessage" class="text-xs font-bold text-destructive text-center">{{ errorMessage }}</p>

          <Button
            type="button"
            @click="handleConnect"
            :disabled="loading"
            class="w-full bg-[#102b70] hover:bg-[#0b225e] text-white font-bold h-10 shadow"
          >
            <Loader2 v-if="loading" class="mr-2 h-4 w-4 animate-spin" />
            <span>{{ loading ? 'Connecting...' : 'Connect to Server' }}</span>
          </Button>

          <div class="flex items-center gap-3 py-0.5">
            <div class="flex-1 h-px bg-border"></div>
            <span class="text-[10px] font-bold text-muted-foreground uppercase">or</span>
            <div class="flex-1 h-px bg-border"></div>
          </div>

          <Button
            type="button"
            variant="outline"
            @click="useDefault"
            class="w-full text-xs font-semibold h-10"
          >
            Use Default Local Server
          </Button>
        </CardContent>
      </Card>
    </div>

    <!-- Footer Note -->
    <div class="text-center pt-6 space-y-1 text-xs text-muted-foreground">
      <div class="flex items-center justify-center gap-1.5">
        <ShieldCheck class="w-4 h-4 text-emerald-600" />
        <span>Secure Sanctum API Communication</span>
      </div>
    </div>
  </div>
</template>
