<script setup lang="ts">
import AppLayout from '../layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3';
import type { SharedData, User } from '@/types'; // misalnya kamu simpan di file terpisah
import axios from 'axios'
import ActionMenu from '@/components/user/ActionMenu.vue';
import Announcement from '@/components/user/Announcement.vue';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from "@/components/ui/tooltip"
import { Button } from "@/components/ui/button"
import simplebar from 'simplebar-vue';
import { EllipsisVertical, OctagonAlert } from 'lucide-vue-next';

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

onMounted(() => {
    updateDateTime()
    setInterval(updateDateTime, 1000) // Update tiap detik
})

function normalizeIp(ip: string): string {
    return ip
        .split('.')
        .map(octet => String(Number(octet)))
        .join('.');
}

const isOnOfficeNetwork = computed(() => {
    const normalizedClientIp = normalizeIp(clientIp);
    return allowedIps.some((ipObj: any) => normalizedClientIp.startsWith(normalizeIp(ipObj.ip_address)));
});

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
        <div class="flex flex-row h-full justify-between min-h-0 max-h-[calc(97.8vh-var(--header-h))]">
            <div class="p-3 md:p-6 space-y-3 flex-1">
                <!-- User Info with Solid Background -->
                <Announcement />
                <div class="flex gap-5 flex-1">
                    <div class="flex flex-col  gap-3">
                        <Card class="py-2 gap-1">
                            <CardHeader class="mt-1.5 px-6">
                                <CardTitle>
                                    <div class="flex justify-between items-center">
                                        <p class="mb-0.5">IP Address</p>
                                        <div class="flex gap-2 items-center">
                                            <p class="font-mono text-base">{{ clientIp }}</p>
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <OctagonAlert class="text-coral p-0" :size="20" />
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p class="text-coral dark:drop-shadow-lg">Jaringan di luar
                                                        kantor!
                                                    </p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </div>
                                    </div>
                                </CardTitle>
                            </CardHeader>
                        </Card>
                        <Card class="py-2 gap-1">
                            <CardHeader class="mt-1.5 px-6">
                                <CardTitle>
                                    <div class="flex justify-between items-center">
                                        <p class="mb-0.5">Absen</p>
                                        <div class="flex gap-2 items-center">
                                            <Tooltip>
                                                <TooltipTrigger>
                                                    <OctagonAlert class="text-coral p-0" :size="20" />
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p class="text-coral dark:drop-shadow-lg">Jaringan di luar
                                                        kantor!
                                                    </p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </div>
                                    </div>
                                </CardTitle>
                                <CardContent class="px-0">
                                    <div class="flex justify-between items-center">
                                        <Button variant="outline"
                                            class="text-foreground bg-muted max-w-[140px] flex-1 px-2" disabled>Absen
                                            Masuk</Button>
                                        <EllipsisVertical />
                                        <Button variant="outline"
                                            class="text-foreground bg-muted max-w-[140px] flex-1 px-2" disabled>Absen
                                            Pulang</Button>
                                    </div>
                                    <!-- <div class="flex justify-between items-center">
                                    <Button variant="outline"
                                        class="text-neon-fg max-w-[140px] flex-1 px-2 hover:bg-neon-bg cursor-pointer hover:text-neon-fg">Absen
                                        Masuk</Button>
                                    <EllipsisVertical />
                                    <Button variant="outline"
                                        class="text-crimson-fg max-w-[140px] flex-1 px-2 hover:bg-crimson-bg cursor-pointer hover:text-crimson-fg">Absen
                                        Pulang</Button>
                                </div> -->
                                </CardContent>
                            </CardHeader>
                        </Card>
                        <ActionMenu />
                    </div>
                    <div>
                        <Card class="py-4 gap-1">
                            <CardHeader class="mt-1 px-6">
                                <CardTitle>
                                    <div class="flex justify-between items-center">
                                        <p>Status Hari Ini</p>
                                        <p
                                            class="font-normal text-tangerine bg-tangerine/8 text-sm px-2 py-0.5 rounded">
                                            Dinas Luar</p>
                                    </div>
                                </CardTitle>
                            </CardHeader>
                            <CardContent class="flex flex-col gap-1.5 text-xs px-6">
                                <p>{{ now }}</p>
                                <div class="flex gap-3">
                                    <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                    <p class="py-0.5">08:00</p>
                                    <p class="py-0.5">:</p>
                                    <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                </div>
                                <div class="flex gap-3">
                                    <p class="p-0.5 bg-rose rounded-4xl rounded-l-none"></p>
                                    <p class="py-0.5">09:20</p>
                                    <p class="py-0.5">:</p>
                                    <p class="py-0.5">Pengajuan dinas luar diterima</p>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                </div>

                <!-- <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
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

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-2">
                <p class="text-black-600">{{ now }}</p>
                <p>IP: <span class="font-mono">{{ clientIp }}</span></p>
                <p :class="isOnOfficeNetwork ? 'text-green-600' : 'text-yellow-600'">
                    {{ isOnOfficeNetwork ? 'Jaringan kantor!' : 'Jaringan di luar kantor!' }}
                </p>
            </div>

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
            </div> -->
            </div>

        </div>

    </AppLayout>
</template>
