<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const title = ref('')
const author = ref('')
const isbn = ref('')
const category = ref('')
const copies = ref(1)

const handleAddBook = () => {
  router.push('/admin/books')
}
</script>

<template>
  <div class="min-h-screen bg-slate-100 pt-24 pb-16">
    <div class="container mx-auto px-6 max-w-3xl">
      <h1 class="text-2xl font-extrabold text-slate-900 mb-6">Add New Book Record</h1>

      <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <form @submit.prevent="handleAddBook" class="space-y-4">
          <div>
            <label class="block text-xs font-bold uppercase text-slate-600">Book Title</label>
            <input
              v-model="title"
              type="text"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
            />
          </div>

          <div>
            <label class="block text-xs font-bold uppercase text-slate-600">Author</label>
            <input
              v-model="author"
              type="text"
              required
              class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
            />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold uppercase text-slate-600">ISBN</label>
              <input
                v-model="isbn"
                type="text"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
              />
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-600">Copies</label>
              <input
                v-model="copies"
                type="number"
                min="1"
                required
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-[#102b70]"
              />
            </div>
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl bg-[#102b70] text-white font-bold text-sm hover:bg-[#0b225e] shadow transition mt-4"
          >
            Save Book Entry
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
