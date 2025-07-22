<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import Icon from '@/components/Icon.vue';
import { type BreadcrumbItem } from '@/types'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { ref, onMounted, watch } from 'vue';
import axios from 'axios'

const today = new Date()
const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1)

const selectedDate = ref([startOfMonth, today])
const absens = ref<any>([])
const loading = ref(true)

const fetchAbsens = async () => {
    loading.value = true

    const [startDate, endDate] = selectedDate.value.map(d => d?.toISOString().split('T')[0])

    try {
        const response = await axios.get('/history/findmany', {
            params: {
                start_date: startDate,
                end_date: endDate
            }
        })

        absens.value = response.data
        console.log
    } catch (error) {
        console.error('Gagal fetch data absens:', error)
    } finally {
        loading.value = false
    }
}

onMounted(fetchAbsens)
watch(selectedDate, fetchAbsens)

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Riwayat Absen', href: '/absensi' }
]

function badgeClass(status: string) {
    switch (status) {
        case 'Hadir': return 'bg-green-100 text-green-800'
        case 'Terlambat': return 'bg-yellow-100 text-yellow-800'
        case 'Tidak Hadir': return 'bg-red-100 text-red-800'
        default: return 'bg-gray-100 text-gray-800'
    }
}

const exportExcel = () => {
  const [start, end] = selectedDate.value.map(d => d.toISOString().split('T')[0])
  const url = `/history/export?start_date=${start}&end_date=${end}`
  window.open(url, '_blank') // trigger download
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Riwayat Absen</h2>
                <button class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" @click="exportExcel">
                    <Icon name="download" /> Download
                </button>
            </div>
            <div class="w-3xs">
                <Datepicker v-model="selectedDate" :range="true" :enable-time-picker="false" :max-date="new Date()" />
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
                        <!-- Loading -->
                        <tr v-if="loading">
                            <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                Loading data...
                            </td>
                        </tr>

                        <!-- Data ditemukan -->
                        <template v-else-if="absens.length">
                            <tr v-for="r in absens" :key="r.id" class="border-t">
                                <td class="px-4 py-3">{{ r.date }}</td>
                                <td class="px-4 py-3">{{ r.clock_in }}</td>
                                <td class="px-4 py-3">{{ r.clock_out }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-medium rounded" :class="badgeClass(r.status)">
                                        {{ r.status }}
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <!-- Data kosong -->
                        <tr v-else>
                            <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                Data absen kosong.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </AppLayout>
</template>
