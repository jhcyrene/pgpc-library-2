<script setup>
import { ref } from 'vue'

const currentPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')
const message = ref('')

const handleUpdate = () => {
  if (newPassword.value === confirmPassword.value) {
    message.value = 'Account settings updated successfully.'
  }
}
</script>

<template>
  <div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="container mx-auto px-6 max-w-2xl">
      <h1 class="text-2xl font-extrabold text-[#102b70] mb-6">Account Settings</h1>

      <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <div v-if="message" class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium">
          {{ message }}
        </div>

        <form @submit.prevent="handleUpdate" class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">Current Password</label>
            <input
              v-model="currentPassword"
              type="password"
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">New Password</label>
            <input
              v-model="newPassword"
              type="password"
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase">Confirm New Password</label>
            <input
              v-model="confirmPassword"
              type="password"
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
            />
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition"
          >
            Save Password Changes
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
