<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

const title = ref('')
const author = ref('')
const isbn = ref('')
const category = ref('')
const yearFrom = ref('')
const yearTo = ref('')

const handleAdvancedSearch = () => {
  console.log('Advanced search submit:', { title, author, isbn, category, yearFrom, yearTo })
}
</script>

<template>
  <div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="container mx-auto px-6 max-w-4xl">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-extrabold text-[#102b70]">Advanced Catalog Search</h1>
          <p class="text-xs text-slate-500 mt-1">Combine search criteria to find exact library resources.</p>
        </div>
        <RouterLink to="/opac" class="text-xs font-bold text-[#102b70] hover:underline">
          &larr; Back to Simple Search
        </RouterLink>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <form @submit.prevent="handleAdvancedSearch" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Book Title</label>
              <input
                v-model="title"
                type="text"
                placeholder="e.g. Data Structures"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Author</label>
              <input
                v-model="author"
                type="text"
                placeholder="e.g. Tanenbaum"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">ISBN</label>
              <input
                v-model="isbn"
                type="text"
                placeholder="e.g. 978-0134685991"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Category</label>
              <select
                v-model="category"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              >
                <option value="">All Categories</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Science">Science</option>
                <option value="Literature">Literature</option>
              </select>
            </div>
          </div>

          <div class="border-t border-slate-100 pt-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Publication Year Range</label>
            <div class="flex items-center gap-3">
              <input
                v-model="yearFrom"
                type="number"
                placeholder="From (Year)"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              />
              <span class="text-slate-400">–</span>
              <input
                v-model="yearTo"
                type="number"
                placeholder="To (Year)"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-[#102b70]"
              />
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button
              type="reset"
              class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition"
            >
              Reset
            </button>
            <button
              type="submit"
              class="px-8 py-2.5 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition"
            >
              Search Catalog
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
