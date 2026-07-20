<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    default: '',
  },
  items: {
    type: Array,
    default: () => [],
  },
})
</script>

<template>
  <div
    class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-[300px] lg:min-h-0"
  >
    <div class="mb-4 shrink-0">
      <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">{{ title }}</h3>
      <p class="text-xs font-medium text-slate-500 mt-0.5">{{ description }}</p>
    </div>

    <!-- Content / Item List -->
    <div
      class="space-y-3 flex-1 min-h-[180px] lg:min-h-0 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200"
    >
      <slot>
        <div v-if="items.length === 0" class="text-xs text-slate-400 py-4 text-center">
          No data available.
        </div>
        <div
          v-for="(item, index) in items"
          :key="index"
          class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100"
        >
          <span class="text-xs font-medium text-slate-700">{{ item.title || item.name }}</span>
          <span class="text-xs font-bold text-slate-500">{{ item.count || item.value }}</span>
        </div>
      </slot>
    </div>

    <button
      type="button"
      disabled
      class="mt-4 shrink-0 w-full py-2.5 border-2 border-slate-200 bg-slate-50 text-slate-400 font-bold rounded-xl text-sm cursor-not-allowed"
    >
      Reports coming soon
    </button>
  </div>
</template>
