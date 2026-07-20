<script setup>
import { computed } from 'vue'

const props = defineProps({
  book: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'reserve'])

const authorNames = computed(() => {
  if (!props.book) return 'Unknown Author'
  if (props.book.authors && props.book.authors.length > 0) {
    return props.book.authors.map(a => `${a.first_name || ''} ${a.last_name || ''}`.trim()).join(', ')
  }
  return props.book.author || 'Unknown Author'
})

const coverUrl = computed(() => {
  if (!props.book) return ''
  const img = props.book.book_detail?.cover_image || props.book.cover_image
  if (!img) return ''
  if (img.startsWith('data:image')) return img
  return `/storage/${img.replace(/^\/+/, '')}`
})

const categoryName = computed(() => {
  if (!props.book) return 'General'
  if (props.book.categories && props.book.categories.length > 0) {
    return props.book.categories[0].category_name
  }
  return props.book.category || 'General'
})

const isAvailable = computed(() => {
  if (!props.book) return false
  if (props.book.copies_available !== undefined) return props.book.copies_available > 0
  return props.book.available !== false
})
</script>

<template>
  <div v-if="book" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-950/70 backdrop-blur-xs p-0 sm:p-4">
    <div class="bg-white w-full max-w-lg rounded-t-3xl sm:rounded-3xl max-h-[92vh] overflow-y-auto flex flex-col justify-between shadow-2xl relative">
      
      <!-- Top Action Bar -->
      <div class="sticky top-0 bg-white/90 backdrop-blur-md px-6 py-4 flex items-center justify-between z-10 border-b border-slate-100">
        <button type="button" @click="$emit('close')" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-colors">
          ✕
        </button>
        <button type="button" class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
          </svg>
        </button>
      </div>

      <!-- Main Sheet Body (Matching Screen 5 Mockup) -->
      <div class="p-6 space-y-6 flex-1">
        <!-- Centered Cover Image Container -->
        <div class="flex flex-col items-center">
          <div class="w-36 h-52 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xl relative">
            <img v-if="coverUrl" :src="coverUrl" :alt="book.book_title" class="w-full h-full object-cover" />
            <div v-else class="w-full h-full flex flex-col items-center justify-center p-4 text-center text-[#102b70] bg-[#102b70]/5">
              <svg class="w-10 h-10 text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <span class="mt-2 text-[10px] font-black uppercase tracking-wider text-[#102b70]">PGPC LIBRARY</span>
            </div>
          </div>
        </div>

        <!-- Badges & Title -->
        <div class="space-y-2">
          <div class="flex items-center gap-2">
            <span :class="['px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5', isAvailable ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100']">
              <span :class="['w-1.5 h-1.5 rounded-full', isAvailable ? 'bg-emerald-500' : 'bg-rose-500']"></span>
              {{ isAvailable ? 'Available' : 'Checked Out' }}
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-100">
              {{ categoryName }}
            </span>
          </div>

          <h2 class="text-xl font-extrabold text-slate-900 leading-snug">{{ book.book_title || book.title }}</h2>
          <p class="text-xs font-semibold text-slate-500">By {{ authorNames }}</p>
        </div>

        <!-- Spec Table (Matching Screen 5 Mockup) -->
        <div class="bg-slate-50/90 rounded-2xl p-4 border border-slate-100 space-y-2.5 text-xs">
          <div class="flex justify-between items-center py-1">
            <span class="font-bold text-slate-400">ISBN</span>
            <span class="font-bold text-slate-800 font-mono">{{ book.book_detail?.isbn || book.isbn || '978-0-13-604259-4' }}</span>
          </div>
          <div class="flex justify-between items-center py-1 border-t border-slate-200/60">
            <span class="font-bold text-slate-400">Publisher</span>
            <span class="font-bold text-slate-800">{{ book.book_detail?.publisher?.publisher_name || 'Pearson' }}</span>
          </div>
          <div class="flex justify-between items-center py-1 border-t border-slate-200/60">
            <span class="font-bold text-slate-400">Publication Year</span>
            <span class="font-bold text-slate-800">{{ book.book_detail?.publication_year || book.copyright_year || '2021' }}</span>
          </div>
          <div class="flex justify-between items-center py-1 border-t border-slate-200/60">
            <span class="font-bold text-slate-400">Call Number</span>
            <span class="font-bold text-slate-800 font-mono">{{ book.book_detail?.call_number || book.call_number || 'QA76.9.R87 2021' }}</span>
          </div>
          <div class="flex justify-between items-center py-1 border-t border-slate-200/60">
            <span class="font-bold text-slate-400">Copies Available</span>
            <span class="font-bold text-slate-800">{{ book.copies_available ?? 2 }} of {{ book.copies_total ?? 2 }}</span>
          </div>
        </div>

        <!-- Description Paragraph -->
        <div class="space-y-1.5">
          <h4 class="text-xs font-extrabold text-slate-900">Description</h4>
          <p class="text-xs font-medium text-slate-600 leading-relaxed">
            {{ book.description || 'A comprehensive modern introduction to artificial intelligence. Covers agents, problem solving, knowledge representation, machine learning, and more.' }}
          </p>
        </div>
      </div>

      <!-- Bottom Sticky Reserve Action -->
      <div class="sticky bottom-0 bg-white border-t border-slate-100 p-4 z-10">
        <button
          type="button"
          @click="$emit('reserve', book)"
          class="w-full py-3.5 bg-[#102b70] hover:bg-[#0b225e] active:scale-[0.99] text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
          </svg>
          <span>Add to Reserve</span>
        </button>
      </div>
    </div>
  </div>
</template>
