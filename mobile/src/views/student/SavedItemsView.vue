<script setup>
import { ref } from 'vue'

const savedItems = ref([
  { id: 1, title: 'Artificial Intelligence: A Modern Approach', author: 'Stuart Russell', category: 'Computer Science' }
])
</script>

<template>
  <div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="container mx-auto px-6 max-w-4xl">
      <h1 class="text-2xl font-extrabold text-[#102b70] mb-2">Saved Bookmarks</h1>
      <p class="text-xs text-slate-500 mb-6">Your bookmarked titles for future research and borrowing.</p>

      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <div v-if="savedItems.length" class="space-y-3">
          <div
            v-for="item in savedItems"
            :key="item.id"
            class="p-4 rounded-xl border border-slate-100 bg-slate-50 flex items-center justify-between"
          >
            <div>
              <span class="text-[10px] font-bold uppercase tracking-wider text-[#102b70] bg-blue-50 px-2 py-0.5 rounded">
                {{ item.category }}
              </span>
              <h3 class="font-bold text-slate-900 text-sm mt-1">{{ item.title }}</h3>
              <p class="text-xs text-slate-500">{{ item.author }}</p>
            </div>
            <button class="text-xs font-bold text-rose-600 hover:underline">Remove</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
