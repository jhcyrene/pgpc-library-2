<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const password = ref('')
const passwordConfirmation = ref('')

const handleReset = () => {
  if (password.value === passwordConfirmation.value) {
    router.push('/login')
  }
}
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex flex-col justify-center py-12 px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
      <h2 class="text-2xl font-extrabold text-slate-900">Reset Your Password</h2>
      <p class="mt-2 text-xs text-slate-600">Enter a new secure password for your account.</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-6 shadow-md rounded-2xl border border-slate-200">
        <form @submit.prevent="handleReset" class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">New Password</label>
            <input
              v-model="password"
              type="password"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
              placeholder="••••••••"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">Confirm New Password</label>
            <input
              v-model="passwordConfirmation"
              type="password"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
              placeholder="••••••••"
            />
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition"
          >
            Update Password
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
