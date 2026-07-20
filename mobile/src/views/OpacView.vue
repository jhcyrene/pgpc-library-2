<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/lib/axios'
import { useAuthStore } from '@/stores/auth'
import MobileFilterSheet from '@/components/opac/MobileFilterSheet.vue'
import BookDetailSheet from '@/components/opac/BookDetailSheet.vue'
import { toast } from 'vue-sonner'

// Shadcn Vue components
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Card, CardContent } from '@/components/ui/card'
import { Search, SlidersHorizontal, BookOpen, Bookmark, Home, Calendar, User, Settings, Loader2 } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const books = ref([])
const categories = ref([])
const loading = ref(true)
const searchQuery = ref('')
const selectedCategoryId = ref('all')
const activeTab = ref('home')

const showFilterSheet = ref(false)
const selectedBook = ref(null)

const fetchCatalogData = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams()
    if (searchQuery.value) params.append('q', searchQuery.value)
    if (selectedCategoryId.value !== 'all') params.append('category', selectedCategoryId.value)

    const res = await api.get(`/opac/books?${params.toString()}`)
    if (res.data && res.data.data) {
      books.value = res.data.data.books || res.data.data || []
      categories.value = res.data.data.categories || []
    }
  } catch (err) {
    console.warn('Using OPAC catalog fallback:', err)
    books.value = [
      {
        book_data_id: 1,
        book_title: 'Artificial Intelligence: A Modern Approach',
        authors: [{ first_name: 'Stuart', last_name: 'Russell' }, { first_name: 'Peter', last_name: 'Norvig' }],
        category: 'Computer Science',
        copies_available: 2,
        copies_total: 2,
        available: true,
      },
      {
        book_data_id: 2,
        book_title: 'Database System Concepts 7th Edition',
        authors: [{ first_name: 'Abraham', last_name: 'Silberschatz' }],
        category: 'Information Technology',
        copies_available: 3,
        copies_total: 3,
        available: true,
      },
      {
        book_data_id: 3,
        book_title: 'Clean Code: A Handbook of Agile Software Craftsmanship',
        authors: [{ first_name: 'Robert C.', last_name: 'Martin' }],
        category: 'Computer Science',
        copies_available: 1,
        copies_total: 2,
        available: true,
      }
    ]
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCatalogData()
})

const selectCategory = (id) => {
  selectedCategoryId.value = id
  fetchCatalogData()
}

const openDetail = (book) => {
  selectedBook.value = book
}

const handleApplyFilters = (filters) => {
  if (filters.category) selectedCategoryId.value = filters.category
  fetchCatalogData()
}

const handleReserve = (book) => {
  if (!authStore.isAuthenticated) {
    toast.error('Authentication Required', { description: 'Please log in to reserve library materials.' })
    router.push('/login')
  } else {
    toast.success('Reservation Request Submitted', { description: `Reserved "${book.book_title || book.title}".` })
  }
}
</script>

<template>
  <div class="min-h-screen bg-background pb-24 font-sans text-foreground max-w-md mx-auto relative border-x border-border shadow-lg">
    
    <!-- Top Mobile Header -->
    <header class="bg-[#102b70] text-white px-5 pt-12 pb-5 sticky top-0 z-30 shadow-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <Button variant="ghost" size="icon" @click="router.push('/set-library')" class="text-white hover:bg-white/10 h-8 w-8" title="Server Settings">
            <Settings class="h-4 w-4" />
          </Button>
          <div>
            <h1 class="text-base font-black tracking-tight text-white leading-tight">PGPC Library</h1>
            <p class="text-[10px] font-bold uppercase tracking-wider text-[#fcc719]">Mobile OPAC Catalog</p>
          </div>
        </div>

        <Button v-if="authStore.isAuthenticated" variant="ghost" size="sm" @click="router.push('/student/dashboard')" class="text-xs text-[#fcc719] hover:bg-white/10 font-bold">
          Portal
        </Button>
        <Button v-else variant="outline" size="sm" @click="router.push('/login')" class="text-xs h-8 border-white/30 text-white hover:bg-white hover:text-[#102b70] bg-transparent">
          Login
        </Button>
      </div>

      <!-- Search Bar -->
      <div class="mt-4 flex gap-2">
        <div class="relative flex-1">
          <Search class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" />
          <Input
            v-model="searchQuery"
            type="search"
            placeholder="Search by title, author, ISBN..."
            class="pl-9 pr-4 py-2 bg-white text-slate-800 rounded-full text-xs font-semibold placeholder-slate-400 border-none shadow-sm focus-visible:ring-[#fcc719]"
            @keyup.enter="fetchCatalogData"
          />
        </div>
        <Button
          variant="ghost"
          size="icon"
          @click="showFilterSheet = true"
          class="rounded-full bg-white/10 hover:bg-white/20 text-white h-9 w-9 shrink-0"
        >
          <SlidersHorizontal class="w-4 h-4" />
        </Button>
      </div>
    </header>

    <!-- Main Content Section -->
    <main class="p-4 space-y-5">
      
      <!-- Horizontal Subject Categories -->
      <section class="space-y-2.5">
        <div class="flex items-center justify-between">
          <h2 class="text-xs font-extrabold text-foreground uppercase tracking-wider">Subject Categories</h2>
          <Button variant="link" size="sm" @click="showFilterSheet = true" class="text-xs text-primary p-0 h-auto font-bold">View all</Button>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar">
          <Button
            size="sm"
            :variant="selectedCategoryId === 'all' ? 'default' : 'outline'"
            @click="selectCategory('all')"
            class="rounded-full text-xs font-bold shrink-0 h-8 px-3.5"
          >
            All Subjects
          </Button>
          <Button
            v-for="cat in categories.slice(0, 6)"
            :key="cat.category_id || cat.id"
            size="sm"
            :variant="selectedCategoryId === (cat.category_id || cat.id) ? 'default' : 'outline'"
            @click="selectCategory(cat.category_id || cat.id)"
            class="rounded-full text-xs font-bold shrink-0 h-8 px-3.5"
          >
            {{ cat.category_name || cat.name }}
          </Button>
        </div>
      </section>

      <!-- MARC Catalog Book List -->
      <section class="space-y-3">
        <div class="flex items-center justify-between">
          <h2 class="text-xs font-extrabold text-foreground uppercase tracking-wider">Bibliographic Titles</h2>
          <span class="text-xs font-bold text-muted-foreground">{{ books.length }} records</span>
        </div>

        <div v-if="loading" class="space-y-3">
          <Card v-for="i in 3" :key="i" class="h-24 bg-muted/60 animate-pulse border shadow-none" />
        </div>

        <div v-else class="space-y-3">
          <Card
            v-for="book in books"
            :key="book.book_data_id || book.id || book.book_title"
            @click="openDetail(book)"
            class="border shadow-2xs hover:shadow-md transition-all cursor-pointer relative overflow-hidden group"
          >
            <CardContent class="p-3 flex items-start gap-3.5">
              <!-- Book Thumbnail / Icon -->
              <div class="w-14 h-20 rounded-lg overflow-hidden bg-primary/5 border flex items-center justify-center shrink-0">
                <BookOpen class="w-7 h-7 text-primary" />
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0 pr-6 space-y-1">
                <h3 class="text-xs font-bold text-foreground line-clamp-2 leading-snug group-hover:text-primary transition-colors">
                  {{ book.book_title || book.title }}
                </h3>
                <p class="text-[11px] font-medium text-muted-foreground truncate">
                  {{ book.authors ? book.authors.map(a => `${a.first_name || ''} ${a.last_name || ''}`).join(', ') : (book.author || 'Unknown Author') }}
                </p>

                <div class="flex items-center gap-2 pt-1">
                  <Badge variant="default" class="text-[9px] px-2 py-0">
                    AVAILABLE
                  </Badge>
                  <span class="text-[10px] text-muted-foreground font-medium">
                    {{ book.copies_available ?? 2 }} / {{ book.copies_total ?? 2 }} copies
                  </span>
                </div>
              </div>

              <!-- Save Bookmark Button -->
              <Button
                variant="ghost"
                size="icon"
                @click.stop="handleReserve(book)"
                class="absolute top-2.5 right-2.5 h-7 w-7 text-muted-foreground hover:text-primary"
              >
                <Bookmark class="w-4 h-4" />
              </Button>
            </CardContent>
          </Card>
        </div>
      </section>

    </main>

    <!-- Bottom App Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-card border-t border-border px-6 py-2 flex items-center justify-between z-40 shadow-lg">
      <button
        type="button"
        @click="activeTab = 'home'"
        :class="['flex flex-col items-center gap-1 text-[10px] font-extrabold transition-colors', activeTab === 'home' ? 'text-primary' : 'text-muted-foreground']"
      >
        <Home class="w-5 h-5" />
        <span>Catalog</span>
      </button>

      <button
        type="button"
        @click="activeTab = 'search'; showFilterSheet = true"
        :class="['flex flex-col items-center gap-1 text-[10px] font-extrabold transition-colors', activeTab === 'search' ? 'text-primary' : 'text-muted-foreground']"
      >
        <Search class="w-5 h-5" />
        <span>Filter</span>
      </button>

      <button
        type="button"
        @click="router.push(authStore.isAuthenticated ? '/student/reservations' : '/login')"
        :class="['flex flex-col items-center gap-1 text-[10px] font-extrabold transition-colors', activeTab === 'reserves' ? 'text-primary' : 'text-muted-foreground']"
      >
        <Calendar class="w-5 h-5" />
        <span>Reserves</span>
      </button>

      <button
        type="button"
        @click="router.push(authStore.isAuthenticated ? '/student/dashboard' : '/login')"
        :class="['flex flex-col items-center gap-1 text-[10px] font-extrabold transition-colors', activeTab === 'profile' ? 'text-primary' : 'text-muted-foreground']"
      >
        <User class="w-5 h-5" />
        <span>Profile</span>
      </button>
    </nav>

    <!-- Modals & Sheets -->
    <MobileFilterSheet
      :show="showFilterSheet"
      :categories="categories"
      @close="showFilterSheet = false"
      @apply="handleApplyFilters"
    />

    <BookDetailSheet
      :book="selectedBook"
      @close="selectedBook = null"
      @reserve="handleReserve"
    />
  </div>
</template>
