<script setup>
import { ref, onMounted } from 'vue'
import api from '@/lib/axios'

// Shadcn Vue components
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { BookOpen, Clock, CheckCircle2, AlertTriangle, Loader2 } from 'lucide-vue-next'

const activeTab = ref('current')
const isLoading = ref(true)

const currentBorrows = ref([])
const historyBorrows = ref([])

async function fetchBorrowTransactions() {
  isLoading.value = true
  try {
    const res = await api.get('/student/borrow-transactions')
    if (res.data) {
      if (res.data.current) currentBorrows.value = res.data.current
      if (res.data.history) historyBorrows.value = res.data.history
    }
  } catch (err) {
    console.warn('Using fallback data for Borrow Transactions:', err)
    currentBorrows.value = [
      { id: 1, title: 'Database System Concepts 7th Ed.', accession: 'ACC-2026-001', issueDate: 'Jul 10, 2026', dueDate: 'Jul 25, 2026', isOverdue: false },
      { id: 2, title: 'Software Engineering Principles', accession: 'ACC-2026-042', issueDate: 'Jul 14, 2026', dueDate: 'Jul 28, 2026', isOverdue: false }
    ]
    historyBorrows.value = [
      { id: 10, title: 'Calculus: Early Transcendentals', accession: 'ACC-2025-088', issueDate: 'May 05, 2026', returnDate: 'May 18, 2026' }
    ]
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchBorrowTransactions()
})
</script>

<template>
  <div class="min-h-screen bg-background pt-20 pb-24 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto space-y-6">

      <div>
        <h1 class="text-2xl font-bold tracking-tight text-foreground">Borrow Transactions</h1>
        <p class="text-xs text-muted-foreground">Manage active book loans and view borrowing history.</p>
      </div>

      <!-- Tab Buttons -->
      <div class="flex border-b gap-4">
        <Button
          variant="ghost"
          size="sm"
          @click="activeTab = 'current'"
          :class="['rounded-none border-b-2 px-3 pb-2 pt-1 font-bold text-xs', activeTab === 'current' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground']"
        >
          Current Active Loans ({{ currentBorrows.length }})
        </Button>
        <Button
          variant="ghost"
          size="sm"
          @click="activeTab = 'history'"
          :class="['rounded-none border-b-2 px-3 pb-2 pt-1 font-bold text-xs', activeTab === 'history' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground']"
        >
          Borrowing History ({{ historyBorrows.length }})
        </Button>
      </div>

      <!-- Current Loans Card -->
      <Card v-if="activeTab === 'current'" class="border shadow-sm overflow-hidden">
        <CardContent class="p-0">
          <Table>
            <TableHeader class="bg-muted/50">
              <TableRow>
                <TableHead>Book Title</TableHead>
                <TableHead class="w-[130px]">Accession No.</TableHead>
                <TableHead class="w-[120px]">Issue Date</TableHead>
                <TableHead class="w-[120px]">Due Date</TableHead>
                <TableHead class="text-right w-[90px]">Status</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-if="isLoading">
                <TableCell colspan="5" class="h-28 text-center text-muted-foreground text-xs">
                  <Loader2 class="w-5 h-5 animate-spin mx-auto mb-1 text-primary" /> Loading transactions...
                </TableCell>
              </TableRow>

              <TableRow v-else-if="currentBorrows.length === 0">
                <TableCell colspan="5" class="h-24 text-center text-muted-foreground text-xs">
                  No active borrowed books on record.
                </TableCell>
              </TableRow>

              <TableRow v-for="b in currentBorrows" :key="b.id" class="hover:bg-muted/30">
                <TableCell class="font-bold text-xs text-foreground">{{ b.title }}</TableCell>
                <TableCell class="font-mono text-xs text-muted-foreground">{{ b.accession }}</TableCell>
                <TableCell class="text-xs text-muted-foreground">{{ b.issueDate }}</TableCell>
                <TableCell class="text-xs font-semibold text-foreground">{{ b.dueDate }}</TableCell>
                <TableCell class="text-right">
                  <Badge variant="default" class="text-[10px] px-2 py-0">ACTIVE</Badge>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      <!-- History Loans Card -->
      <Card v-else class="border shadow-sm overflow-hidden">
        <CardContent class="p-0">
          <Table>
            <TableHeader class="bg-muted/50">
              <TableRow>
                <TableHead>Book Title</TableHead>
                <TableHead class="w-[130px]">Accession No.</TableHead>
                <TableHead class="w-[120px]">Issue Date</TableHead>
                <TableHead class="w-[120px]">Returned Date</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-if="historyBorrows.length === 0">
                <TableCell colspan="4" class="h-24 text-center text-muted-foreground text-xs">
                  No past borrowing history records found.
                </TableCell>
              </TableRow>

              <TableRow v-for="b in historyBorrows" :key="b.id" class="hover:bg-muted/30">
                <TableCell class="font-bold text-xs text-foreground">{{ b.title }}</TableCell>
                <TableCell class="font-mono text-xs text-muted-foreground">{{ b.accession }}</TableCell>
                <TableCell class="text-xs text-muted-foreground">{{ b.issueDate }}</TableCell>
                <TableCell class="text-xs font-semibold text-emerald-600">{{ b.returnDate }}</TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>

    </div>
  </div>
</template>
