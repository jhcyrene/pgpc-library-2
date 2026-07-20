<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink, useRoute } from 'vue-router'

const props = defineProps({
  user: {
    type: Object,
    default: null,
  },
})

const route = useRoute()
const isScrolled = ref(false)
const isMobileMenuOpen = ref(false)

const handleScroll = () => {
  isScrolled.value = window.scrollY > 20
}

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
  <header
    id="main-header"
    :class="[
      'fixed w-full z-50 transition-all duration-300',
      isScrolled || route.path !== '/' ? 'bg-[#102b70] py-3 shadow-md' : 'bg-transparent py-5',
    ]"
  >
    <div class="container mx-auto px-6 md:px-12 flex justify-between items-center">
      <!-- Logo & Wordmark -->
      <RouterLink to="/" class="flex items-center gap-3" aria-label="PGPC Library home">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden shadow-sm">
          <img
            src="https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e"
            alt="PGPC Logo"
            class="w-full h-full object-cover"
          />
        </div>
        <span class="brand-text font-bold text-lg hidden sm:block text-white transition-colors">
          Padre Garcia Polytechnic College
        </span>
      </RouterLink>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-8">
        <RouterLink
          to="/"
          :class="[
            'nav-text font-medium transition-colors hover:text-gold',
            route.path === '/' ? 'text-amber-400 font-bold' : 'text-gray-100',
          ]"
        >
          Home
        </RouterLink>

        <RouterLink
          to="/opac"
          :class="[
            'nav-text font-medium transition-colors hover:text-gold',
            route.path === '/opac' ? 'text-amber-400 font-bold' : 'text-gray-100',
          ]"
        >
          OPAC
        </RouterLink>

        <a href="#contact" class="nav-text font-medium transition-colors hover:text-gold text-gray-100">
          Contact
        </a>

        <div class="flex items-center gap-3">
          <template v-if="user">
            <RouterLink
              to="/student/dashboard"
              class="px-5 py-2.5 rounded-full bg-[#fcc719] text-[#102b70] font-bold hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300"
            >
              Dashboard
            </RouterLink>
            <button
              type="button"
              class="px-5 py-2.5 rounded-full border border-white/20 text-white font-semibold hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300 cursor-pointer"
            >
              Log out
            </button>
          </template>
          <template v-else>
            <RouterLink
              to="/login"
              class="px-5 py-2.5 rounded-full border border-white/20 text-white font-semibold hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300"
            >
              Log in
            </RouterLink>
            <RouterLink
              to="/register"
              class="px-5 py-2.5 rounded-full bg-[#fcc719] text-[#102b70] font-bold hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300"
            >
              Register
            </RouterLink>
          </template>
        </div>
      </nav>

      <!-- Mobile Menu Toggle -->
      <button
        type="button"
        @click="toggleMobileMenu"
        class="md:hidden p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 menu-icon text-white transition-colors"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>

    <!-- Mobile Dropdown Panel -->
    <div
      v-if="isMobileMenuOpen"
      class="absolute top-full left-0 w-full bg-[#102b70]/95 backdrop-blur-md shadow-lg py-4 px-6 flex flex-col gap-4 md:hidden"
    >
      <RouterLink
        to="/"
        @click="closeMobileMenu"
        :class="route.path === '/' ? 'text-white font-bold' : 'text-gray-300 hover:text-amber-400'"
        class="font-medium py-2 border-b border-white/10 transition-colors"
      >
        Home
      </RouterLink>

      <RouterLink
        to="/opac"
        @click="closeMobileMenu"
        :class="route.path === '/opac' ? 'text-white font-bold' : 'text-gray-300 hover:text-amber-400'"
        class="font-medium py-2 border-b border-white/10 transition-colors"
      >
        OPAC
      </RouterLink>

      <a
        href="#contact"
        @click="closeMobileMenu"
        class="text-gray-300 hover:text-amber-400 font-medium py-2 border-b border-white/10 transition-colors"
      >
        Contact
      </a>

      <div class="flex flex-col gap-3 mt-4">
        <template v-if="user">
          <RouterLink
            to="/student/dashboard"
            @click="closeMobileMenu"
            class="px-5 py-3 rounded-xl bg-[#fcc719] text-[#102b70] font-bold text-center hover:bg-[#ffd84c] transition-all duration-300"
          >
            Dashboard
          </RouterLink>
        </template>
        <template v-else>
          <RouterLink
            to="/login"
            @click="closeMobileMenu"
            class="px-5 py-3 rounded-xl border border-white/20 text-white font-semibold text-center hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300"
          >
            Log in
          </RouterLink>
          <RouterLink
            to="/register"
            @click="closeMobileMenu"
            class="px-5 py-3 rounded-xl bg-[#fcc719] text-[#102b70] font-bold text-center hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300"
          >
            Register
          </RouterLink>
        </template>
      </div>
    </div>
  </header>
</template>
