<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { ref, computed, onMounted } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3';
import type { SharedData, User } from '@/types'; // misalnya kamu simpan di file terpisah
import axios from 'axios'
import DiagramCircle from '@/components/admin/dashboard/DiagramCircle.vue';
import ListStatus from '@/components/admin/dashboard/ListStatus.vue';
import ListApproval from '@/components/admin/dashboard/ListApproval.vue';
import Announcement from '@/components/user/Announcement.vue';
import ListAnnoucement from '@/components/admin/dashboard/ListAnnoucement.vue';
import ListIp from '@/components/admin/dashboard/ListIp.vue';
const page = usePage<SharedData>();
const { summary, data, information, ips } =
    defineProps<{
        summary: Record<string, any[]>,
        data: Record<string, any[]>,
        information: Record<string, any[]>
        ips: Record<string, any[]>
    }>()

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
        title: 'Dashboard',
        href: 'admin/dashboard',
    },

];
</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">
        <Head title="Dashboard" />

        <div class="@container flex-1 flex">
            <div class="
            flex-1 flex max-w-full w-full justify-between min-h-0 min-w-0
            overflow-hidden
            @[1017px]:h-[calc(100vh-var(--header-h)-17px)]
        ">
                <div class="flex flex-1 py-6 px-8 space-x-8 min-w-0">
                    <div class="flex flex-col space-y-6">
                        <DiagramCircle :summary="summary" />
                        <ListIp :ips="ips" />
                    </div>
                    <div class="flex-1 flex flex-col gap-6 min-w-0">
                        <ListStatus :summary="summary" :data="data" />
                        <ListAnnoucement :information="information" />
                    </div>
                </div>
                <div
                    class="hidden h-full @[1017px]:flex max-w-80 bg-sand flex-col flex-1 rounded-l-2xl shadow-md min-w-0 pl-10 pr-3 pt-8 gap-2">
                    <ListApproval />
                </div>
            </div>
        </div>
    </AdminAppLayout>
</template>
