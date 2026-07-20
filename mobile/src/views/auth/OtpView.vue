<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const otpCode = ref('')

const handleVerify = () => {
  if (otpCode.value.length === 6) {
    router.push('/reset-password')
  }
}
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex flex-col justify-center py-12 px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
      <h2 class="text-2xl font-extrabold text-slate-900">Enter Verification Code</h2>
      <p class="mt-2 text-xs text-slate-600">Please enter the 6-digit OTP code sent to your email.</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-6 shadow-md rounded-2xl border border-slate-200">
        <form @submit.prevent="handleVerify" class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">6-Digit Code</label>
            <input
              v-model="otpCode"
              type="text"
              maxlength="6"
              required
              class="mt-1 w-full text-center tracking-widest text-xl font-mono rounded-xl border border-slate-300 px-4 py-3 text-slate-900 outline-none focus:border-[#102b70]"
              placeholder="123456"
            />
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition"
          >
            Verify Code
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
