<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const message = ref('')

const handleForgot = () => {
  message.value = 'OTP code sent to your registered email address.'
  setTimeout(() => {
    router.push('/otp')
  }, 1500)
}
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex flex-col justify-center py-12 px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <h2 class="text-center text-2xl font-extrabold text-slate-900">Forgot Password</h2>
      <p class="mt-2 text-center text-xs text-slate-600">Enter your email to receive a password reset OTP code.</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-6 shadow-md rounded-2xl border border-slate-200">
        <div v-if="message" class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium">
          {{ message }}
        </div>

        <form @submit.prevent="handleForgot" class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">Email Address</label>
            <input
              v-model="email"
              type="email"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
              placeholder="student@example.com"
            />
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition"
          >
            Send OTP Code
          </button>
        </form>

        <div class="mt-5 text-center text-xs text-slate-500">
          Remembered your password?
          <RouterLink to="/login" class="font-bold text-[#102b70] hover:underline">Back to Login</RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>
