<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { ref, computed, onMounted } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3';
import type { SharedData, User } from '@/types'; // misalnya kamu simpan di file terpisah
import axios from 'axios'
const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? ''
const page = usePage<SharedData>();
const attendanceToday = computed(() => page.props.attendanceToday);
const summary = computed(() => page.props.summary);
const todayDate = page.props.todayDate;
const user = page.props.auth.user as User
const clientIp = page.props.userIp;
console.log(page.props, 'attendanceToday')

const now = ref('')

function updateDateTime() {
  const waktu = new Date()
  const options: Intl.DateTimeFormatOptions = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }

  now.value = new Intl.DateTimeFormat('id-ID', options).format(waktu)
}

// onMounted(async () => {
//   try {
//     const res = await axios.get(route('client.ip'))
//     clientIp.value = res.data.ip
//   } catch (error) {
//     console.error('❌ Gagal ambil IP:', error)
//   }
// })

onMounted(() => {
  updateDateTime()
  setInterval(updateDateTime, 1000) // Update tiap detik
})

// onMounted(async () => {
//   try {
//     const res = await fetch('https://api.ipify.org?format=json');
//     const data = await res.json();
//     userIp.value = data.ip;
//     console.log('IP user:', userIp.value);
//   } catch (error) {
//     userIp.value = 'Gagal mengambil IP';
//     console.error(error);
//   }
// });


// const userIp = page.props.userIp

// const isOnOfficeNetwork = computed(() => (clientIp.startsWith('172.29.') ||
//   clientIp.startsWith('10.') ||
//   clientIp === 'kantor-static-ip'))

// const absen = (type: 'masuk' | 'pulang') => {
//   router.post('/absen', { type }, {
//     preserveScroll: true,
//     onSuccess: () => {
//       router.reload({ only: ['attendanceToday', 'summary'] })
//     },
//     onError: (err) => console.error('Absen gagal', err),
//   })
// }

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboar',
    href: '/dashboard',
  },
  
];
</script>

      <template>
      <AdminAppLayout>
      <div class="flex flex-col min-h-screen bg-gray-50">
      <main class="flex-grow w-full p-6">
        <div class="max-w-7xl mx-auto flex flex-col justify-between h-full">

      <!-- Header -->
      <div class="text-center mb-10">
          <h1 class="text-2xl font-bold text-purple-700">Selamat Datang di Sistem Kehadiran Karyawan</h1>
          <p class="text-gray-600">Lacak dan kelola kehadiran secara efisien</p>
      </div>

      <!-- Form & Absensi -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Pencarian -->
        <div class="bg-white p-4 rounded shadow">
          <h2 class="text-lg font-semibold mb-4">Laporan Kehadiran</h2>
          <input
            v-model="search"
            placeholder="Masukkan nama karyawan"
            class="w-full border px-3 py-2 rounded mb-3"
          />
          <button class="bg-black text-white px-4 py-2 rounded">Cari</button>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="bg-white p-4 rounded shadow">
          <h2 class="text-lg font-semibold mb-2">Nama Karyawan</h2>
          <div v-if="attendanceToday">
            <p>Masuk: {{ attendanceToday.jam_masuk }}</p>
            <p>Pulang: {{ attendanceToday.jam_pulang }}</p>
            <p>Status: {{ attendanceToday.status }}</p>
          </div>
          <div v-else>
            <p class="text-gray-500">Belum ada data absensi hari ini.</p>
          </div>
        </div>
      </div>

      <!-- Statistik Kehadiran -->
      <div class="mt-10">
        <h2 class="text-2xl font-semibold text-center mb-2">Laporan Kehadiran</h2>
        <p class="text-lg text-center text-gray-500 mb-8">Lihat data absensi real-time</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-purple-50 text-center border border-purple-200 p-4 rounded-lg">
          <p class="text-purple-800">Hadir</p>
          <p class="text-2xl font-bold text-purple-900">{{ summary['Hadir'] || 0 }}</p>
        </div>
        <div class="bg-yellow-50 text-center border border-yellow-200 p-4 rounded-lg">
          <p class="text-yellow-800">Izin</p>
          <p class="text-2xl font-bold text-yellow-900">{{ summary['Izin'] || 0 }}</p>
        </div>
        <div class="bg-red-50 text-center border border-red-200 p-4 rounded-lg">
          <p class="text-red-800">Sakit</p>
          <p class="text-2xl font-bold text-red-900">{{ summary['Sakit'] || 0 }}</p>
        </div>
        <div class="bg-orange-50 text-center border border-orange-200 p-4 rounded-lg">
          <p class="text-orange-800">Terlambat</p>
          <p class="text-2xl font-bold text-orange-900">{{ summary['Terlambat'] || 0 }}</p>
        </div>
      </div>
      </div>
    </div>
  </main>
  </div>
  </AdminAppLayout>
</template>
     