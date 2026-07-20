<script setup>
import { ref } from 'vue'

const totalFines = ref(0.0)
const fineRecords = ref([])
</script>

<template>
  <div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="container mx-auto px-6 max-w-4xl">
      <h1 class="text-2xl font-extrabold text-[#102b70] mb-2">Fines & Penalties</h1>
      <p class="text-xs text-slate-500 mb-6">Review library account fine statements and payment status.</p>

      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
        <div class="py-6">
          <p class="text-xs font-bold uppercase text-slate-400">Total Outstanding Balance</p>
          <p class="text-4xl font-black text-[#102b70] mt-2">₱{{ totalFines.toFixed(2) }}</p>
          <p class="text-xs text-emerald-600 font-semibold mt-2">You have no outstanding overdue fines.</p>
        </div>
      </div>
    </div>
  </div>
</template>
