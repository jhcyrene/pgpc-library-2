<script setup>
import { ref } from 'vue'

const props = defineProps({
  show: Boolean,
  categories: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['close', 'apply'])

const availability = ref('available')
const selectedCategory = ref('all')
const yearFrom = ref('2000')
const yearTo = ref('2026')
const sortBy = ref('relevance')

const handleReset = () => {
  availability.value = 'all'
  selectedCategory.value = 'all'
  yearFrom.value = ''
  yearTo.value = ''
  sortBy.value = 'relevance'
}

const handleApply = () => {
  emit('apply', {
    availability: availability.value,
    category: selectedCategory.value,
    yearFrom: yearFrom.value,
    yearTo: yearTo.value,
    sort: sortBy.value,
  })
  emit('close')
}
</script>

<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-900/60 backdrop-blur-xs p-0 sm:p-4">
    <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl max-h-[90vh] overflow-y-auto flex flex-col justify-between shadow-2xl animate-in fade-in slide-in-from-bottom duration-200">
      
      <!-- Top Header -->
      <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between z-10">
        <h3 class="text-base font-extrabold text-slate-900">Filters</h3>
        <button type="button" @click="handleReset" class="text-xs font-bold text-blue-600 hover:text-blue-800">
          Reset
        </button>
      </div>

      <!-- Content Options (Matching Screen 4 Mockup) -->
      <div class="p-6 space-y-6 flex-1">
        <!-- Availability -->
        <div class="space-y-2.5">
          <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Availability</p>
          <div class="space-y-1.5">
            <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Available</span>
              <input type="radio" v-model="availability" value="available" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
            <label class="flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Not Available</span>
              <input type="radio" v-model="availability" value="not_available" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
            <label class="flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Checked Out</span>
              <input type="radio" v-model="availability" value="checked_out" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
          </div>
        </div>

        <!-- Category -->
        <div class="space-y-2.5">
          <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Category</p>
          <div class="space-y-1.5">
            <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">All Categories</span>
              <input type="radio" v-model="selectedCategory" value="all" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
            <label v-for="cat in categories" :key="cat.category_id" class="flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">{{ cat.category_name }}</span>
              <input type="radio" v-model="selectedCategory" :value="cat.category_id" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
          </div>
        </div>

        <!-- Publication Year Range -->
        <div class="space-y-2.5">
          <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Publication Year</p>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold text-slate-400 mb-1">From</label>
              <input type="number" v-model="yearFrom" placeholder="2000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 outline-none" />
            </div>
            <div>
              <label class="block text-[10px] font-bold text-slate-400 mb-1">To</label>
              <input type="number" v-model="yearTo" placeholder="2026" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 outline-none" />
            </div>
          </div>
        </div>

        <!-- Sort By -->
        <div class="space-y-2.5">
          <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Sort By</p>
          <div class="space-y-1.5">
            <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Relevance</span>
              <input type="radio" v-model="sortBy" value="relevance" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
            <label class="flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Title: A to Z</span>
              <input type="radio" v-model="sortBy" value="title_asc" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
            <label class="flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-100 cursor-pointer">
              <span class="text-xs font-bold text-slate-800">Title: Z to A</span>
              <input type="radio" v-model="sortBy" value="title_desc" class="w-4 h-4 text-[#102b70] accent-[#102b70]" />
            </label>
          </div>
        </div>
      </div>

      <!-- Bottom Actions -->
      <div class="sticky bottom-0 bg-white border-t border-slate-100 p-4 grid grid-cols-2 gap-3 z-10">
        <button type="button" @click="$emit('close')" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
          Cancel
        </button>
        <button type="button" @click="handleApply" class="w-full py-3 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl transition-all shadow-sm">
          Apply Filters
        </button>
      </div>
    </div>
  </div>
</template>
