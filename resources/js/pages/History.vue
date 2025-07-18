<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const absens = page.props.absens;
import { router } from '@inertiajs/vue3';

import { ref, onMounted } from 'vue';

const props = defineProps<{
  absens: {
    date: string;
    clock_in: string | null;
    clock_out: string | null;
    status: string;
    }[];
}>();

onMounted(() => {
  setInterval(() => {
    router.reload({ only: ['absens'] });
  }, 10000); // 10 detik
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Riwayat Absen', href: '/history' }
]

const records = [
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
            <div class="p-6 space-y-6 text-gray-800">
              <!-- Header -->
              <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Riwayat Absen</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                  <i class="i-lucide-download mr-1" /> Download
                </button>
              </div>

              <!-- Filter bulan -->
              <select class="border px-3 py-2 rounded text-sm">
                <option>Januari 2025</option>
                <option>Desember 2024</option>
              </select>

              <!-- Tabel absensi -->
                <div class="overflow-x-auto bg-white rounded-xl shadow max-h-[600px] overflow-y-auto">
                <table class="w-full table-auto text-sm text-left">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-4 py-3">Tanggal</th>
                      <th class="px-4 py-3">Absen Masuk</th>
                      <th class="px-4 py-3">Absen Pulang</th>
                      <th class="px-4 py-3">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(record, index) in props.absens" :key="index">
                    <td class="border p-2">{{ record.date }}</td>
                    <td class="border p-2">{{ record.clock_in ?? '--:--' }}</td>
                    <td class="border p-2">{{ record.clock_out ?? '--:--' }}</td>
                    <td class="border p-2">
                      <span
                        :class="{
                          'bg-yellow-200 text-yellow-800 px-2 py-1 rounded': record.status === 'Terlambat',
                          'bg-green-100 text-green-800 px-2 py-1 rounded': record.status === 'Hadir',
                          'bg-red-200 text-red-800 px-2 py-1 rounded': record.status === 'Tidak Hadir',
                        }"
                      >
                        {{ record.status }}
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </AppLayout>
        </template>




