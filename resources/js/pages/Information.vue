<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { usePage } from '@inertiajs/vue3';
const page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Informasi', href: '/informasi' }
]


</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex items-center justify-center min-h-screen p-6">
      <div class="w-full max-w-6xl">
        <h1 class="text-3xl font-bold mb-8 text-center">Informasi</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Libur -->
          <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold flex items-center mb-4">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 2a1 1 0 011 1v1h6V3a1 1 0 112 0v1h1a2 2 0 012 2v2H3V6a2 2 0 012-2h1V3a1 1 0 011-1zM3 9h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
              </svg>
              Libur
            </h2>
            <p class="text-sm text-gray-500 mb-3">Libur di tahun 2025:</p>
            <ul class="space-y-2 text-gray-700 text-sm">
              <li>✅ Hari Buruh Nasional - 1 Mei</li>
              <li>✅ Hari Raya Waisak - 12, 13 Mei</li>
              <li>✅ Kenaikan Isa Al Masih - 29, 30 Mei</li>
            </ul>
          </div>

          <!-- Pengumuman Perusahaan -->
          <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold flex items-center mb-4">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.293 9.293a1 1 0 011.414 0L15 13.586V5a1 1 0 112 0v12a1 1 0 01-1 1H5a1 1 0 110-2h8.586l-4.293-4.293a1 1 0 010-1.414z" />
              </svg>
              Pengumuman Perusahaan
            </h2>
            <h3 class="font-semibold text-gray-800 mb-2">Renovasi Kantor</h3>
            <p class="text-sm text-gray-700">
              Renovasi lantai 3 dimulai minggu depan. Harap ikuti pengaturan sementara.
            </p>
          </div>

          <!-- Aktivitas Tim -->
          <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold flex items-center mb-4">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 7a3 3 0 100-6 3 3 0 000 6zM3 6a3 3 0 100-6 3 3 0 000 6zm7 8a5 5 0 00-5 5H0a8 8 0 0116 0h-5a5 5 0 00-5-5zM3 14a5 5 0 015-5h4a5 5 0 015 5v1H3v-1z" />
              </svg>
              Aktivitas Tim
            </h2>
            <h3 class="font-semibold text-gray-800 mb-2">Team Workshop</h3>
            <p class="text-sm text-gray-700">10 Juni 2025</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
