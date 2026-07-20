<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'

const router = useRouter()

const studentNo = ref('')
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const errorMessage = ref('')
const isLoading = ref(false)

const handleRegister = async () => {
  if (password.value !== passwordConfirmation.value) {
    errorMessage.value = 'Passwords do not match'
    return
  }
  isLoading.value = true
  errorMessage.value = ''
  try {
    const res = await fetch('/api/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        student_no: studentNo.value,
        name: name.value,
        email: email.value,
        password: password.value,
      }),
    })
    if (!res.ok) {
      const data = await res.json()
      throw new Error(data.message || 'Registration failed')
    }
    router.push('/login')
  } catch (err) {
    errorMessage.value = err.message
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen bg-slate-100 flex flex-col justify-center py-12 px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <div class="flex justify-center">
        <div class="w-16 h-16 rounded-full bg-[#102b70] flex items-center justify-center text-[#fcc719] font-bold text-xl shadow-md">
          PG
        </div>
      </div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900">
        Student Registration
      </h2>
      <p class="mt-2 text-center text-sm text-slate-600">
        Create your account to discover resources and manage library activity.
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-slate-200">
        <div v-if="errorMessage" class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm font-medium">
          {{ errorMessage }}
        </div>

        <form class="space-y-5" @submit.prevent="handleRegister">
          <div>
            <label class="block text-sm font-medium text-slate-700">Student No.</label>
            <input
              v-model="studentNo"
              type="text"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-slate-900 shadow-sm focus:border-[#102b70] outline-none"
              placeholder="e.g. 2024-00123"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700">Full Name</label>
            <input
              v-model="name"
              type="text"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-slate-900 shadow-sm focus:border-[#102b70] outline-none"
              placeholder="John Doe"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700">Email Address</label>
            <input
              v-model="email"
              type="email"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-slate-900 shadow-sm focus:border-[#102b70] outline-none"
              placeholder="student@g.batstate-u.edu.ph"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700">Password</label>
            <input
              v-model="password"
              type="password"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-slate-900 shadow-sm focus:border-[#102b70] outline-none"
              placeholder="••••••••"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
            <input
              v-model="passwordConfirmation"
              type="password"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-slate-900 shadow-sm focus:border-[#102b70] outline-none"
              placeholder="••••••••"
            />
          </div>

          <button
            type="submit"
            :disabled="isLoading"
            class="w-full py-3 px-4 rounded-xl bg-[#102b70] text-white font-bold hover:bg-[#0b225e] shadow-md transition-all duration-200 disabled:opacity-50"
          >
            {{ isLoading ? 'Creating Account...' : 'Register Account' }}
          </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
          Already have an account?
          <RouterLink to="/login" class="font-bold text-[#102b70] hover:underline">
            Sign in
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>
