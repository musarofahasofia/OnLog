<script setup lang="ts">
import AppLayout from '../layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
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
const allowedIps = page.props.allowed_ips;
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

const isOnOfficeNetwork = computed(() => {
  return allowedIps.some((item: { ip_address: string }) =>
    clientIp.value.startsWith(item.ip_address)
  )
})

const absen = (type: 'masuk' | 'pulang') => {
  router.post('/absen', { type }, {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['attendanceToday', 'summary'] })
    },
    onError: (err) => console.error('Absen gagal', err),
  })
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Profile',
    href: '/Profile',
  },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6 text-gray-800">

      <!-- User Info with Solid Background -->
      <div class="rounded-xl shadow overflow-hidden">
        <div class="p-6 flex flex-col items-center text-center text-white" style="background-color: #7C81AD;">
          <!-- Foto Profil -->
          <img :src="user.photo ? `storage/${user.photo}` : `https://ui-avatars.com/api/?name=${user.name}`"
            alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-white mb-2" />
          <h2 class="text-xl font-semibold">{{ user.name }}</h2>
          <p class="text-sm opacity-90">Manajer</p>

        </div>
      </div>


      <!-- Status Realtime -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
        <h3 class="font-semibold text-lg">Status Hari Ini</h3>

        <div v-if="attendanceToday">
          <p>
            <span class="mr-2">
              Masuk :
            </span>
            <span v-if="attendanceToday?.clock_in"
              :class="{ 'text-green-600': attendanceToday.status === 'Hadir', 'text-yellow-600': attendanceToday.status === 'Terlambat' }">
              {{ attendanceToday.clock_in }}
            </span>
            <span v-else>
              -
            </span>
          </p>

          <p>
            <span class="mr-2">
              Pulang :
            </span>
            <span v-if="attendanceToday?.clock_out" class="text-red-600">
              {{ attendanceToday.clock_out }}
            </span>
            <span v-else>
              -
            </span>
          </p>
          <p>
            <span class="mr-2">
              Status :
            </span>
            <span class="font-bold" :class="{
              'text-green-600': attendanceToday.status === 'Hadir',
              'text-yellow-600': attendanceToday.status === 'Terlambat',
              'text-red-600': attendanceToday.status === 'Tidak Hadir'
            }">
              {{ attendanceToday.status }}
            </span>
          </p>
        </div>

        <div v-else>
          <p class="text-red-600">Belum ada absen hari ini</p>
        </div>
      </div>

      <!-- Info Tanggal & IP -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
        <p class="text-black-600">{{ now }}</p>
        <p>IP: <span class="font-mono">{{ clientIp }}</span></p>
        <p :class="isOnOfficeNetwork ? 'text-green-600' : 'text-yellow-600'">
          {{ isOnOfficeNetwork ? 'Jaringan kantor!' : 'Jaringan di luar kantor!' }}
        </p>
      </div>



      <!-- Tombol Absen -->
      <div class="flex flex-col sm:flex-row gap-4">
        <button @click="absen('masuk')" :disabled="!isOnOfficeNetwork || attendanceToday?.clock_in" :class="[
          'rounded-xl px-4 py-2 font-semibold shadow',
          (!isOnOfficeNetwork || attendanceToday?.clock_in)
            ? 'bg-gray-300 text-gray-600 cursor-not-allowed'
            : 'bg-green-500 text-white hover:bg-green-600'
        ]">
          ABSEN MASUK
        </button>

        <button @click="absen('pulang')" :disabled="!isOnOfficeNetwork || attendanceToday?.clock_out" :class="[
          'rounded-xl px-4 py-2 font-semibold shadow',
          (!isOnOfficeNetwork || attendanceToday?.clock_out)
            ? 'bg-gray-300 text-gray-600 cursor-not-allowed'
            : 'bg-red-500 text-white hover:bg-red-600'
        ]">
          ABSEN PULANG
        </button>
      </div>


      <!-- Section: Laporan Kehadiran -->
      <div class="text-center space-y-2">
        <h3 class="text-xl font-semibold">Laporan Kehadiran</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Lihat data absensi real-time</p>
        <button class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">
          <Link :href="route('history')" prefetch
            class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">
          Lihat Selengkapnya
          </Link>

        </button>
      </div>


      <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 grid grid-cols-3 gap-4 text-center">
        <div>
          <p class="text-lg font-bold">{{ summary?.presence ?? 0 }}</p>
          <p>Total Kehadiran</p>
        </div>
        <div>
          <p class="text-lg font-bold">{{ summary?.absence ?? 0 }}</p>
          <p>Total Tidak Hadir</p>
        </div>
        <div>
          <p class="text-lg font-bold">{{ summary?.late ?? 0 }}</p>
          <p>Total Terlambat</p>
        </div>
      </div>
    </div>

  </AppLayout>
</template>
