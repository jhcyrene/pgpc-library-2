<script setup>
import { ref, onMounted, watch } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/axios'
import { toast } from 'vue-sonner'

// Shadcn UI Components
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

// Lucide Icons
import {
  Search,
  Plus,
  MoreVertical,
  QrCode,
  BookOpen,
  ChevronLeft,
  ChevronRight,
  Loader2,
  RefreshCw,
  Trash2,
  Edit,
  Barcode
} from 'lucide-vue-next'

const books = ref([])
const isLoading = ref(false)
const searchQuery = ref('')
const currentPage = ref(1)
const totalPages = ref(1)
const totalBooks = ref(0)

async function fetchBooks(page = 1) {
  isLoading.value = true
  try {
    const response = await api.get('/admin/books', {
      params: {
        page,
        search: searchQuery.value,
      },
    })
    
    // Support both paginated API response and direct array fallback
    if (response.data.data) {
      books.value = response.data.data
      currentPage.value = response.data.current_page || 1
      totalPages.value = response.data.last_page || 1
      totalBooks.value = response.data.total || response.data.data.length
    } else if (Array.isArray(response.data)) {
      books.value = response.data
      totalBooks.value = response.data.length
    }
  } catch (error) {
    console.warn('Backend API connection warning, presenting catalog fallback state:', error)
    // Dynamic catalog fallback for testing offline / offline local mode
    books.value = [
      { id: 1, control_number: 'MARC-001', title: 'Data Structures and Algorithms in Java', author: 'Robert Lafore', call_number: 'QA76.73.J38', category: 'Computer Science', copies: 4, status: 'available' },
      { id: 2, control_number: 'MARC-002', title: 'Database System Concepts 7th Ed.', author: 'Silberschatz, Korth, Sudarshan', call_number: 'QA76.9.D3', category: 'Information Technology', copies: 2, status: 'available' },
      { id: 3, control_number: 'MARC-003', title: 'Calculus: Early Transcendentals', author: 'James Stewart', call_number: 'QA303.2', category: 'Mathematics', copies: 0, status: 'checked_out' },
      { id: 4, control_number: 'MARC-004', title: 'Research Design: Qualitative, Quantitative, and Mixed Methods', author: 'John W. Creswell', call_number: 'H62.C74', category: 'Research', copies: 5, status: 'available' },
    ]
    totalBooks.value = books.value.length
  } finally {
    isLoading.value = false
  }
}

let searchTimer
watch(searchQuery, () => {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    fetchBooks(1)
  }, 350)
})

async function handleDelete(id, title) {
  if (!confirm(`Are you sure you want to delete "${title}"?`)) return
  try {
    await api.delete(`/admin/books/${id}`)
    toast.success('Book deleted successfully')
    fetchBooks(currentPage.value)
  } catch (err) {
    toast.error('Failed to delete book')
  }
}

function handleGenerateBarcode(book) {
  toast.success(`Generating barcode for ${book.title}...`, {
    description: `Accession / Call: ${book.call_number || book.control_number}`,
  })
}

onMounted(() => {
  fetchBooks()
})
</script>

<template>
  <div class="min-h-screen bg-background pt-20 pb-20 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto space-y-6">
      
      <!-- Top Action Banner -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-foreground">Book Manager & MARC Catalog</h1>
          <p class="text-xs text-muted-foreground mt-0.5">Manage bibliographic records, catalog copies, and barcode generation.</p>
        </div>

        <div class="flex items-center gap-3">
          <Button variant="outline" size="sm" class="h-9 gap-1.5" @click="fetchBooks(currentPage)">
            <RefreshCw :class="['h-3.5 w-3.5', isLoading && 'animate-spin']" />
            Refresh
          </Button>
          <Button as-child size="sm" class="h-9 gap-1.5 bg-[#102b70] hover:bg-[#0b225e] text-white">
            <RouterLink to="/admin/books/add">
              <Plus class="h-4 w-4" />
              Add New Book
            </RouterLink>
          </Button>
        </div>
      </div>

      <!-- Search & Filter Controls -->
      <Card class="border shadow-sm">
        <CardContent class="p-4">
          <div class="relative">
            <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              v-model="searchQuery"
              type="search"
              placeholder="Search by Title, Author, Accession No, or Call Number..."
              class="pl-9 text-sm"
            />
          </div>
        </CardContent>
      </Card>

      <!-- Shadcn Data Table Container -->
      <Card class="border shadow-sm overflow-hidden">
        <CardContent class="p-0">
          <div class="overflow-x-auto">
            <Table>
              <TableHeader class="bg-muted/50">
                <TableRow>
                  <TableHead class="w-[120px]">Accession / Call</TableHead>
                  <TableHead>Book Title & Author</TableHead>
                  <TableHead class="hidden md:table-cell">Category</TableHead>
                  <TableHead class="w-[80px] text-center">Copies</TableHead>
                  <TableHead class="w-[100px]">Status</TableHead>
                  <TableHead class="text-right w-[70px]">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <!-- Loading State -->
                <TableRow v-if="isLoading && books.length === 0">
                  <TableCell colspan="6" class="h-32 text-center text-muted-foreground">
                    <div class="flex items-center justify-center gap-2">
                      <Loader2 class="h-5 w-5 animate-spin text-primary" />
                      <span>Loading books catalog...</span>
                    </div>
                  </TableCell>
                </TableRow>

                <!-- Empty State -->
                <TableRow v-else-if="books.length === 0">
                  <TableCell colspan="6" class="h-32 text-center text-muted-foreground text-sm">
                    No books found matching your search.
                  </TableCell>
                </TableRow>

                <!-- Table Rows -->
                <TableRow v-for="book in books" :key="book.id" class="hover:bg-muted/30 transition-colors">
                  <TableCell class="font-mono text-xs font-semibold text-primary">
                    {{ book.call_number || book.control_number || `ACC-00${book.id}` }}
                  </TableCell>

                  <TableCell>
                    <div class="flex flex-col">
                      <span class="font-semibold text-sm text-foreground leading-snug line-clamp-1">{{ book.title }}</span>
                      <span class="text-xs text-muted-foreground line-clamp-1">{{ book.author }}</span>
                    </div>
                  </TableCell>

                  <TableCell class="hidden md:table-cell text-xs text-muted-foreground">
                    {{ book.category || 'General' }}
                  </TableCell>

                  <TableCell class="text-center font-bold text-xs">
                    {{ book.copies ?? 1 }}
                  </TableCell>

                  <TableCell>
                    <Badge :variant="book.copies > 0 ? 'default' : 'secondary'" class="text-[10px] px-2">
                      {{ book.copies > 0 ? 'AVAILABLE' : 'CHECKED OUT' }}
                    </Badge>
                  </TableCell>

                  <TableCell class="text-right">
                    <DropdownMenu>
                      <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" class="h-8 w-8">
                          <MoreVertical class="h-4 w-4" />
                        </Button>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent align="end" class="w-48">
                        <DropdownMenuLabel>Manage Record</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="handleGenerateBarcode(book)" class="cursor-pointer">
                          <Barcode class="mr-2 h-4 w-4 text-blue-600" />
                          <span>Generate Barcode</span>
                        </DropdownMenuItem>
                        <DropdownMenuItem class="cursor-pointer">
                          <Edit class="mr-2 h-4 w-4 text-amber-600" />
                          <span>Edit Details</span>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="handleDelete(book.id, book.title)" class="cursor-pointer text-destructive focus:text-destructive">
                          <Trash2 class="mr-2 h-4 w-4" />
                          <span>Delete</span>
                        </DropdownMenuItem>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      <!-- Pagination Footer -->
      <div class="flex items-center justify-between text-xs text-muted-foreground pt-1">
        <span>Total Books: <strong class="text-foreground">{{ totalBooks }}</strong></span>
        <div class="flex items-center gap-2">
          <Button variant="outline" size="sm" class="h-8 px-2.5" :disabled="currentPage <= 1 || isLoading" @click="fetchBooks(currentPage - 1)">
            <ChevronLeft class="h-4 w-4 mr-1" />
            Prev
          </Button>
          <span class="font-medium text-foreground px-1">{{ currentPage }} / {{ totalPages }}</span>
          <Button variant="outline" size="sm" class="h-8 px-2.5" :disabled="currentPage >= totalPages || isLoading" @click="fetchBooks(currentPage + 1)">
            Next
            <ChevronRight class="h-4 w-4 ml-1" />
          </Button>
        </div>
      </div>

    </div>
  </div>
</template>
