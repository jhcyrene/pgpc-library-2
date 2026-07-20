<script setup>
import { ref, onMounted, computed } from 'vue'
import { RouterLink } from 'vue-router'
import api from '@/lib/axios'

// Shadcn Vue UI Primitives
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import {
  BookOpen,
  Plus,
  Search,
  AlertTriangle,
  Clock,
  CheckCircle,
  Users,
  Layers,
  ArrowRight,
  TrendingUp,
  ShieldAlert,
  Loader2
} from 'lucide-vue-next'

const stats = ref({
  total_titles: 1248,
  total_copies: 3590,
  active_members: 512,
  borrowed_items: 84,
  overdue_items: 3,
  pending_reservations: 5,
})

const currentBorrowers = ref([])
const mostBorrowed = ref([])
const attentionItems = ref([])
const isLoading = ref(true)

const currentDateFormatted = computed(() => {
  return new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})

const greetingTime = computed(() => {
  const hour = new Date().getHours()
  if (hour < 12) return 'morning'
  if (hour < 18) return 'afternoon'
  return 'evening'
})

async function fetchDashboardData() {
  isLoading.value = true
  try {
    const res = await api.get('/admin/dashboard/stats')
    if (res.data && res.data.stats) {
      stats.value = res.data.stats
      if (res.data.current_borrowers) currentBorrowers.value = res.data.current_borrowers
      if (res.data.most_borrowed) mostBorrowed.value = res.data.most_borrowed
    }
  } catch (err) {
    console.warn('Using fallback data for Admin Dashboard:', err)
    currentBorrowers.value = [
      { id: 1, member_name: 'Juan Dela Cruz', student_id: '2023-0142', book_title: 'Database System Concepts 7th Ed.', borrow_date: 'Jul 15, 2026', due_date: 'Jul 28, 2026', status: 'Active' },
      { id: 2, member_name: 'Maria Santos', student_id: '2024-0089', book_title: 'Artificial Intelligence: A Modern Approach', borrow_date: 'Jul 18, 2026', due_date: 'Jul 25, 2026', status: 'Active' },
      { id: 3, member_name: 'Mark Reyes', student_id: '2022-0311', book_title: 'Calculus: Early Transcendentals', borrow_date: 'Jul 02, 2026', due_date: 'Jul 16, 2026', status: 'Overdue' },
    ]
    mostBorrowed.value = [
      { id: 1, title: 'Data Structures & Algorithms in Java', author: 'Robert Lafore', borrows_count: 42 },
      { id: 2, title: 'Database System Concepts', author: 'Silberschatz, Korth', borrows_count: 38 },
      { id: 3, title: 'Clean Code: Handbook of Agile Software', author: 'Robert C. Martin', borrows_count: 31 },
    ]
    attentionItems.value = [
      { id: 1, type: 'overdue', title: '3 Overdue Book Loans', message: 'Mark Reyes (Calculus) is past due since Jul 16.' },
      { id: 2, type: 'ready', title: '5 Pending Hold Requests', message: 'Reservations awaiting staff counter confirmation.' },
    ]
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchDashboardData()
})
</script>

<template>
  <div class="min-h-screen bg-background pt-20 pb-24 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-6">

      <!-- ROW 1: HERO & REQUIRES ATTENTION -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Greeting Banner (Matching admin.partials.greetingBanner) -->
        <Card class="lg:col-span-2 border-none bg-gradient-to-br from-[#102b70] to-[#1e46a3] text-white shadow-md overflow-hidden relative group">
          <div class="absolute -right-10 -top-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700 pointer-events-none"></div>
          <div class="absolute right-20 -bottom-20 w-40 h-40 bg-[#fcc719] opacity-10 rounded-full blur-2xl pointer-events-none"></div>

          <!-- Background Watermark Logo -->
          <img
            src="/images/hd-pgpc-logo.png"
            alt="PGPC Seal"
            class="absolute -right-6 -bottom-6 w-48 h-48 opacity-10 grayscale object-contain pointer-events-none"
          />

          <CardContent class="p-6 md:p-8 relative z-10 flex flex-col justify-between h-full space-y-6">
            <div class="space-y-2">
              <p class="text-white/60 text-xs font-bold uppercase tracking-wider">{{ currentDateFormatted }}</p>
              <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight tracking-tight">
                Good {{ greetingTime }}, <span class="text-[#fcc719]">Librarian Administrator</span>
              </h1>
              <p class="text-slate-300 text-sm font-medium max-w-xl leading-relaxed">
                Welcome to the PGPC Library Management portal. Oversee bibliographic catalog records, circulation loans, and active reservations.
              </p>
            </div>

            <div class="flex flex-wrap gap-3">
              <Button as-child size="sm" class="bg-[#fcc719] hover:bg-[#ffd84c] text-[#102b70] font-bold h-10 px-5 shadow">
                <RouterLink to="/admin/books/add">
                  <Plus class="w-4 h-4 mr-1.5" /> Add New Book Title
                </RouterLink>
              </Button>
              <Button as-child variant="outline" size="sm" class="border-white/20 text-white hover:bg-white/10 bg-transparent h-10 px-5 font-bold">
                <RouterLink to="/admin/books">
                  <Search class="w-4 h-4 mr-1.5 text-[#fcc719]" /> Manage Catalog
                </RouterLink>
              </Button>
            </div>
          </CardContent>
        </Card>

        <!-- Requires Attention Card -->
        <Card class="border shadow-sm flex flex-col justify-between">
          <CardHeader class="pb-3 border-b bg-muted/30">
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base font-extrabold">Requires Attention</CardTitle>
                <CardDescription class="text-xs">Items needing action</CardDescription>
              </div>
              <Badge variant="destructive" class="text-xs font-bold px-2.5">
                {{ stats.overdue_items + stats.pending_reservations }}
              </Badge>
            </div>
          </CardHeader>
          <CardContent class="p-4 space-y-3">
            <div v-if="attentionItems.length === 0" class="text-center py-6 text-xs text-muted-foreground">
              <CheckCircle class="w-8 h-8 text-emerald-500 mx-auto mb-2" />
              <p class="font-bold text-foreground">All Caught Up</p>
              <p class="text-[11px]">No overdue or pending alerts.</p>
            </div>

            <div
              v-for="item in attentionItems"
              :key="item.id"
              :class="['p-3 rounded-xl border text-xs font-medium space-y-0.5', item.type === 'overdue' ? 'bg-red-50 border-red-200 text-red-800' : 'bg-amber-50 border-amber-200 text-amber-900']"
            >
              <div class="flex items-center justify-between font-bold">
                <span>{{ item.title }}</span>
                <ShieldAlert v-if="item.type === 'overdue'" class="w-4 h-4 text-red-600" />
                <Clock v-else class="w-4 h-4 text-amber-600" />
              </div>
              <p class="text-[11px] opacity-90">{{ item.message }}</p>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- ROW 2: 4-COLUMN STATS CARDS -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <Card class="border shadow-2xs">
          <CardContent class="p-5 flex items-center justify-between">
            <div>
              <p class="text-xs font-bold uppercase text-muted-foreground tracking-wider">Total Titles</p>
              <p class="text-2xl font-black text-primary mt-1">{{ stats.total_titles.toLocaleString() }}</p>
              <p class="text-[10px] text-muted-foreground mt-0.5">MARC records</p>
            </div>
            <div class="p-3 rounded-2xl bg-primary/10 text-primary">
              <BookOpen class="w-6 h-6" />
            </div>
          </CardContent>
        </Card>

        <Card class="border shadow-2xs">
          <CardContent class="p-5 flex items-center justify-between">
            <div>
              <p class="text-xs font-bold uppercase text-muted-foreground tracking-wider">Total Copies</p>
              <p class="text-2xl font-black text-foreground mt-1">{{ stats.total_copies.toLocaleString() }}</p>
              <p class="text-[10px] text-muted-foreground mt-0.5">Physical items</p>
            </div>
            <div class="p-3 rounded-2xl bg-muted text-foreground">
              <Layers class="w-6 h-6" />
            </div>
          </CardContent>
        </Card>

        <Card class="border shadow-2xs">
          <CardContent class="p-5 flex items-center justify-between">
            <div>
              <p class="text-xs font-bold uppercase text-muted-foreground tracking-wider">Active Members</p>
              <p class="text-2xl font-black text-emerald-600 mt-1">{{ stats.active_members.toLocaleString() }}</p>
              <p class="text-[10px] text-muted-foreground mt-0.5">Registered students</p>
            </div>
            <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600">
              <Users class="w-6 h-6" />
            </div>
          </CardContent>
        </Card>

        <Card class="border shadow-2xs">
          <CardContent class="p-5 flex items-center justify-between">
            <div>
              <p class="text-xs font-bold uppercase text-muted-foreground tracking-wider">Borrowed Items</p>
              <p class="text-2xl font-black text-amber-500 mt-1">{{ stats.borrowed_items.toLocaleString() }}</p>
              <p class="text-[10px] text-muted-foreground mt-0.5">Active loans</p>
            </div>
            <div class="p-3 rounded-2xl bg-amber-50 text-amber-500">
              <Clock class="w-6 h-6" />
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- ROW 3: CURRENT BORROWERS TABLE & MOST BORROWED -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Current Borrowers Table (2/3) -->
        <Card class="lg:col-span-2 border shadow-sm overflow-hidden flex flex-col">
          <CardHeader class="pb-3 border-b bg-muted/30 flex flex-row items-center justify-between">
            <div>
              <CardTitle class="text-base font-bold">Current Active Borrowers</CardTitle>
              <CardDescription class="text-xs">Students with active circulation loans</CardDescription>
            </div>
            <Button variant="outline" size="sm" as-child class="h-8 text-xs font-bold">
              <RouterLink to="/admin/books">View All</RouterLink>
            </Button>
          </CardHeader>
          <CardContent class="p-0 flex-1">
            <Table>
              <TableHeader class="bg-muted/50">
                <TableRow>
                  <TableHead>Member / Student</TableHead>
                  <TableHead>Book Title</TableHead>
                  <TableHead class="hidden sm:table-cell">Due Date</TableHead>
                  <TableHead class="text-right w-[90px]">Status</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-if="isLoading">
                  <TableCell colspan="4" class="h-28 text-center text-muted-foreground">
                    <Loader2 class="w-5 h-5 animate-spin mx-auto mb-1" />
                    <span>Loading borrowers...</span>
                  </TableCell>
                </TableRow>

                <TableRow v-for="b in currentBorrowers" :key="b.id" class="hover:bg-muted/30">
                  <TableCell>
                    <div class="flex flex-col">
                      <span class="font-bold text-xs text-foreground">{{ b.member_name }}</span>
                      <span class="text-[10px] text-muted-foreground">{{ b.student_id }}</span>
                    </div>
                  </TableCell>
                  <TableCell class="font-medium text-xs text-foreground line-clamp-1 max-w-[180px]">
                    {{ b.book_title }}
                  </TableCell>
                  <TableCell class="hidden sm:table-cell text-xs text-muted-foreground font-mono">
                    {{ b.due_date }}
                  </TableCell>
                  <TableCell class="text-right">
                    <Badge :variant="b.status === 'Overdue' ? 'destructive' : 'default'" class="text-[10px] px-2 py-0">
                      {{ b.status.toUpperCase() }}
                    </Badge>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </CardContent>
        </Card>

        <!-- Most Borrowed Titles Sub-Card (1/3) -->
        <Card class="border shadow-sm flex flex-col justify-between">
          <CardHeader class="pb-3 border-b bg-muted/30">
            <CardTitle class="text-base font-bold flex items-center justify-between">
              <span>Most Borrowed Titles</span>
              <TrendingUp class="w-4 h-4 text-primary" />
            </CardTitle>
            <CardDescription class="text-xs">Top circulation records</CardDescription>
          </CardHeader>
          <CardContent class="p-4 space-y-3.5">
            <div
              v-for="(item, idx) in mostBorrowed"
              :key="item.id || idx"
              class="p-3 rounded-xl border bg-muted/20 flex items-center justify-between"
            >
              <div class="min-w-0 pr-2">
                <p class="text-xs font-bold text-foreground line-clamp-1">{{ item.title }}</p>
                <p class="text-[10px] text-muted-foreground truncate">{{ item.author }}</p>
              </div>
              <Badge variant="secondary" class="font-bold text-[10px] shrink-0 bg-primary/10 text-primary">
                {{ item.borrows_count }} borrows
              </Badge>
            </div>
          </CardContent>
        </Card>

      </div>

    </div>
  </div>
</template>
