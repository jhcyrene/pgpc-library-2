<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <footer id="contact" class="bg-gray-900 text-gray-300 py-12 px-6 mt-auto">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Brand Column -->
        <div>
          <RouterLink to="/" class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden">
              <img
                src="https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e"
                alt="PGPC Logo"
                class="w-full h-full object-cover"
              />
            </div>
            <span class="font-bold text-xl text-white">PGPC Library</span>
          </RouterLink>
          <p class="text-sm text-gray-400 leading-relaxed">
            Taga-PGPC Ako: Matalino, Disiplinado, Mabuting Tao, Ipinagmamalaki ko!
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-white font-bold mb-4 text-base">Quick Links</h4>
          <ul class="space-y-2 text-sm">
            <li><RouterLink to="/" class="hover:text-amber-400 transition-colors">Home</RouterLink></li>
            <li><RouterLink to="/opac" class="hover:text-amber-400 transition-colors">OPAC Search</RouterLink></li>
            <li><RouterLink to="/login" class="hover:text-amber-400 transition-colors">Student Portal</RouterLink></li>
          </ul>
        </div>

        <!-- Categories -->
        <div>
          <h4 class="text-white font-bold mb-4 text-base">Top Categories</h4>
          <ul class="space-y-2 text-sm">
            <li><RouterLink to="/opac?category=Computer+Science" class="hover:text-amber-400 transition-colors">Computer Science</RouterLink></li>
            <li><RouterLink to="/opac?category=Engineering" class="hover:text-amber-400 transition-colors">Engineering</RouterLink></li>
            <li><RouterLink to="/opac?category=Education" class="hover:text-amber-400 transition-colors">Education</RouterLink></li>
            <li><RouterLink to="/opac?category=Business" class="hover:text-amber-400 transition-colors">Business & Accountancy</RouterLink></li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h4 class="text-white font-bold mb-4 text-base">Contact Us</h4>
          <ul class="space-y-3 text-sm">
            <li class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>Poblacion, Padre Garcia, Batangas</span>
            </li>
            <li class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <a href="mailto:info@padregarcia.gov.ph" class="hover:text-amber-400 transition-colors">info@padregarcia.gov.ph</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-10 pt-6 text-center text-xs text-gray-500">
        <p>&copy; 2026 Padre Garcia Polytechnic College Library. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>
