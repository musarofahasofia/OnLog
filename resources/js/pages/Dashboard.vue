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
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import simplebar from 'simplebar-vue';
import { CalendarPlus, EllipsisVertical, InfoIcon, OctagonAlert } from 'lucide-vue-next';

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
        title: 'Dashboard',
        href: '/Dashboard',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex max-w-full w-full h-full justify-between min-h-0 xl:max-h-[calc(97.8vh-var(--header-h))] overflow-hidden min-w-0">
            <div class="p-3 md:p-6 space-y-6 flex flex-col flex-1 min-w-0 max-w-full overflow-hidden">
                <div class="flex flex-col gap-3 w-full min-w-0 flex-1 overflow-hidden">
                    <simplebar class="max-w-full overflow-x-auto min-w-0">
                        <div class="flex flex-row gap-3  flex-nowrap w-full min-w-0 pb-4 ">
                            <Announcement />
                        </div>
                    </simplebar>
                    <div
                        class="flex gap-3 sm:gap-5 flex-1 flex-col sm:flex-row md:flex-col lg:flex-row w-full overflow-y-auto">
                        <div class="flex flex-col gap-3 w-full sm:w-1/2 md:w-full lg:w-1/2">
                            <Card class="py-2 gap-1 ">
                                <CardHeader class="mt-1.5 px-3 md:px-6">
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
                                <CardHeader class="mt-1.5 px-3 md:px-6">
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
                                                class="text-foreground bg-muted max-w-[140px] flex-1 px-2"
                                                disabled>Absen
                                                Masuk</Button>
                                            <EllipsisVertical />
                                            <Button variant="outline"
                                                class="text-foreground bg-muted max-w-[140px] flex-1 px-2"
                                                disabled>Absen
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
                        <div class="w-full sm:w-1/2 md:w-full lg:w-1/2 flex flex-col gap-3">
                            <Card class="py-2 gap-1">
                                <CardHeader class="mt-1.5 px-3 md:px-6">
                                    <CardTitle>
                                        <div class="flex justify-between items-center">
                                            <p>Statistic</p>
                                            <p class="font-normal text-muted-foreground text-sm px-2 rounded">
                                                Desember 2025
                                            </p>
                                        </div>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent class="grid grid-cols-2 gap-1.5 text-xs px-6">
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <p class=" text-3xl font-bold">23<span></span></p>
                                            <p>Total Masuk</p>
                                        </CardContent>
                                    </Card>
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <div class="flex items-end space-x-1">
                                                <p class=" text-3xl font-bold">23<span></span></p>
                                                <Tooltip>
                                                    <TooltipTrigger>
                                                        <InfoIcon class="text-muted-foreground p-0 mb-1.5" :size="16" />
                                                    </TooltipTrigger>
                                                    <TooltipContent>
                                                        <p class="text-coral dark:drop-shadow-lg">Jaringan di luar
                                                            kantor!
                                                        </p>
                                                    </TooltipContent>
                                                </Tooltip>
                                            </div>
                                            <p>Izin/Cuti</p>
                                        </CardContent>
                                    </Card>
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <p class=" text-3xl font-bold">23<span></span></p>
                                            <p class="text-nowrap">Sisa Cuti Tahunan</p>
                                        </CardContent>
                                    </Card>
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <p class=" text-3xl font-bold">23<span></span></p>
                                            <p>Terlambat</p>
                                        </CardContent>
                                    </Card>
                                </CardContent>
                            </Card>
                            <Card class="py-2 gap-1 min-h-0 flex flex-col">
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
                                <div class="min-h-0 flex-1 flex flex-col px-6 gap-1.5 text-xs ">
                                    <p>{{ now }}</p>
                                    <simplebar data-simplebar-auto-hide="true"
                                        class="min-h-0 flex flex-col flex-1">
                                        <div class="flex flex-col gap-1.5">
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
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <p class="p-0.5 bg-amber rounded-4xl rounded-l-none"></p>
                                                <p class="py-0.5">08:00</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">Pengajuan dinas luar dsafa dafsasd dasf as</p>
                                            </div>
                                        </div>
                                    </simplebar>
                                </div>



                            </Card>
                        </div>

                    </div>
                </div>
            </div>
            <div
                class="hidden xl:flex max-w-80 bg-sand/30 flex-col flex-1 rounded-l-2xl shadow-md min-w-0 pl-10 pr-5 pt-8 gap-6">
                <div class="flex justify-between">
                    <p class="text-lg font-extrabold">Calendar</p>
                </div>
                <simplebar data-simplebar-auto-hide="true" class="flex overflow-y-auto min-h pr-1 mb-3">
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-3 lg:text-sm text-xs ">
                            <p class="font-bold">{{ now }}</p>
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
                        </div>
                        <div class="flex flex-col gap-3 text-sm">
                            <p class="font-bold">{{ now }}</p>
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
                        </div>
                        <div class="flex flex-col gap-3 text-sm">
                            <p class="font-bold">{{ now }}</p>
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
                        </div>
                        <div class="flex flex-col gap-3 text-sm">
                            <p class="font-bold">{{ now }}</p>
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
                        </div>
                        <div class="flex flex-col gap-3 text-sm">
                            <p class="font-bold">{{ now }}</p>
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
                        </div>
                    </div>
                </simplebar>
            </div>
        </div>

    </AppLayout>
</template>
