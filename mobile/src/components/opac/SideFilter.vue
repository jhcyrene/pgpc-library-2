<script setup>
import { ref } from 'vue'

const props = defineProps({
  categories: {
    type: Array,
    default: () => [],
  },
  statusOptions: {
    type: Object,
    default: () => ({ available: 'Available', borrowed: 'Borrowed' }),
  },
  sortOptions: {
    type: Object,
    default: () => ({
      relevance: 'Relevance',
      newest: 'Newest Arrivals',
      title_asc: 'Title (A-Z)',
    }),
  },
})

const emit = defineEmits(['apply-filters', 'clear-filters'])

const selectedStatuses = ref([])
const selectedCategories = ref([])
const yearFrom = ref('')
const yearTo = ref('')
const selectedSort = ref('relevance')

const handleApply = () => {
  emit('apply-filters', {
    status: selectedStatuses.value,
    category: selectedCategories.value,
    year_from: yearFrom.value,
    year_to: yearTo.value,
    sort: selectedSort.value,
  })
}

const handleClear = () => {
  selectedStatuses.value = []
  selectedCategories.value = []
  yearFrom.value = ''
  yearTo.value = ''
  selectedSort.value = 'relevance'
  emit('clear-filters')
}
</script>

<template>
  <aside class="min-w-0" aria-label="Catalog filters">
    <form @submit.prevent="handleApply" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
      <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#102b70] text-[#fcc719]">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12m-9 8h6" />
          </svg>
        </span>
        <div>
          <h2 class="font-bold text-[#102b70]">Filter Catalog</h2>
          <p class="mt-0.5 text-xs text-slate-500">Refine the current results</p>
        </div>
      </div>

      <!-- Availability -->
      <div class="mt-4 border-t border-slate-100 pt-4">
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
          Availability
        </span>
        <div class="space-y-2">
          <label
            v-for="(label, value) in statusOptions"
            :key="value"
            class="flex items-center gap-2.5 text-sm font-medium text-slate-700 cursor-pointer"
          >
            <input
              type="checkbox"
              :value="value"
              v-model="selectedStatuses"
              class="h-4 w-4 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]/25"
            />
            {{ label }}
          </label>
        </div>
      </div>

      <!-- Category -->
      <div class="mt-4 border-t border-slate-100 pt-4">
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
          Category
        </span>
        <div class="max-h-48 space-y-2 overflow-y-auto pr-1">
          <label
            v-for="cat in categories"
            :key="cat.category_id || cat.name"
            class="flex items-center gap-2.5 text-sm font-medium text-slate-700 cursor-pointer"
          >
            <input
              type="checkbox"
              :value="cat.category_id || cat.name"
              v-model="selectedCategories"
              class="h-4 w-4 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]/25"
            />
            {{ cat.category_name || cat.name }}
          </label>
        </div>
      </div>

      <!-- Publication year range -->
      <div class="mt-4 border-t border-slate-100 pt-4">
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
          Publication Year
        </span>
        <div class="flex items-center gap-2">
          <input
            type="number"
            placeholder="From"
            v-model="yearFrom"
            min="1900"
            max="2026"
            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-[#102b70]"
          />
          <span class="text-slate-400">–</span>
          <input
            type="number"
            placeholder="To"
            v-model="yearTo"
            min="1900"
            max="2026"
            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-[#102b70]"
          />
        </div>
      </div>

      <!-- Sort -->
      <div class="mt-4 border-t border-slate-100 pt-4">
        <label for="catalog-sort" class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
          Sort Results
        </label>
        <select
          id="catalog-sort"
          v-model="selectedSort"
          class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:border-[#102b70]"
        >
          <option v-for="(label, value) in sortOptions" :key="value" :value="value">
            {{ label }}
          </option>
        </select>
      </div>

      <div class="mt-5 grid gap-2">
        <button
          type="submit"
          class="w-full rounded-xl bg-[#102b70] px-5 py-3 font-bold text-white transition hover:bg-[#0b225e]"
        >
          Apply Filters
        </button>
        <button
          type="button"
          @click="handleClear"
          class="w-full rounded-xl border border-slate-300 bg-white px-5 py-3 font-bold text-slate-700 transition hover:bg-slate-50"
        >
          Clear Filters
        </button>
      </div>
    </form>
  </aside>
</template>
