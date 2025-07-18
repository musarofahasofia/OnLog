<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const absens = page.props.absens;
console.log(absens);

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Riwayat Absen', href: '/absensi' }
]

const records = [
  { date: 'Jan 15, 2025', masuk: '09:05', pulang: '06:00', status: 'Terlambat' },
  { date: 'Jan 14, 2025', masuk: '08:55', pulang: '06:00', status: 'Hadir' },
  { date: 'Jan 13, 2025', masuk: '--:--', pulang: '--:--', status: 'Tidak Hadir' },
]

function badgeClass(status: string) {
  switch (status) {
    case 'Hadir': return 'bg-green-100 text-green-800'
    case 'Terlambat': return 'bg-yellow-100 text-yellow-800'
    case 'Tidak Hadir': return 'bg-red-100 text-red-800'
    default: return 'bg-gray-100 text-gray-800'
  }
}
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Riwayat Absen</h2>
        <button class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          <span class="i-lucide-download" /> Download
        </button>
      </div>

      <!-- Dropdown filter -->
      <div>
        <select class="border border-gray-300 px-3 py-2 rounded text-sm">
          <option>January 2025</option>
          <option>December 2024</option>
        </select>
      </div>

      <!-- Tabel -->
      <div class="overflow-x-auto rounded shadow border">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3">Tanggal</th>
              <th class="px-4 py-3">Absen Masuk</th>
              <th class="px-4 py-3">Absen Pulang</th>
              <th class="px-4 py-3">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="r in absens" :key="r.date" class="border-t">
              <td class="px-4 py-3">{{ r.date }}</td>
              <td class="px-4 py-3">{{ r.clock_in }}</td>
              <td class="px-4 py-3">{{ r.clock_out }}</td>
              <td class="px-4 py-3">
                <span class="px-2 py-1 text-xs font-medium rounded" :class="badgeClass(r.status)">
                  {{ r.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

     
    </div>
  </AppLayout>
</template>
