<script setup lang="ts">
import AppLayout from '../layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
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
import UserAttendance from '@/components/user/UserAttendance.vue';
import { useToast } from "vue-toastification";
import { useAttendance } from '@/composables/useAttendance'
import { useStatus } from '@/composables/useStatus';

const { badges, fetchStatus } = useStatus()
const { fetchHistory } = useAttendance()
onMounted(fetchStatus)
const toast = useToast();
const page = usePage<SharedData>();
const { userIp: clientIp, allowed_ips, todayDate, attendanceToday, summary, history, information } =
    defineProps<{
        userIp: string
        allowed_ips: { ip_address: string }[]
        todayDate: string
        attendanceToday: {
            clock_in: string | null
            clock_out: string | null
            status: string | null
        } | null
        summary: {
            presence: number
            late: number
        }
        history: Record<string, any[]>,
        information: Record<string, any[]>,
    }>()

const today = computed(() => {
    const now = new Date()

    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(now)
})

const firstHistoryEntry = computed(() => {
    const entry = Object.entries(history)[0]

    if (!entry) return null

    const [dateLabel, items] = entry

    return {
        dateLabel,
        items,
        isToday: dateLabel === todayDate,
    }
})

console.log(firstHistoryEntry.value?.dateLabel)

function normalizeIp(ip: string): string {
    return ip
        .split('.')
        .map(octet => String(Number(octet)))
        .join('.');
}

const isOnOfficeNetwork = computed(() => {
    const normalizedClientIp = normalizeIp(clientIp);
    return allowed_ips.some((ipObj: any) => normalizedClientIp.startsWith(normalizeIp(ipObj.ip_address)));
});

const formatTime = (date: string) => {
    return new Date(date).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    })
}

const ButtonLoading = ref(false)

const form = useForm({
    client_ip: '',
})

const attend = async (type: 'in' | 'out') => {
    form.client_ip = clientIp

    form.post(route('attend', { action: type }), {
        preserveScroll: true,
        onStart: () => {
            ButtonLoading.value = true
        },
        onSuccess: async () => {
            let ket = type == 'in' ? 'Berhasil Absen Masuk' : 'Berhasil Absem Pulang'
            await fetchStatus()
            await fetchHistory()
            toast.success(ket)
        },
        onError: (err) => toast.error(err.note),
        onFinish: () => {
            ButtonLoading.value = false
        }
    })
}

async function refreshPage() {
    await fetchStatus()
    await fetchHistory()
}

function callToast(type: "success" | "error" | "info" | "warning", message: string) {
    const toastMap = {
        success: toast.success,
        error: toast.error,
        info: toast.info,
        warning: toast.warning,
    };

    toastMap[type]?.(message);
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
        <Head title="Dashboard" />

        <div
            class="flex max-w-full w-full h-full justify-between min-h-0 xl:max-h-[calc(97.8vh-var(--header-h))] overflow-hidden min-w-0">
            <div class="p-3 md:p-6 space-y-6 flex flex-col flex-1 min-w-0 max-w-full overflow-hidden">
                <div class="flex flex-col gap-3 w-full min-w-0 flex-1 overflow-hidden">
                    <simplebar class="max-w-full overflow-x-auto min-w-0">
                        <div class="flex flex-row gap-3  flex-nowrap w-full min-w-0 pb-4 ">
                            <Announcement :information="information" />
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
                                                    <TooltipTrigger v-if="!isOnOfficeNetwork">
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
                                                <template v-if="!isOnOfficeNetwork">
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
                                                </template>
                                                <template v-else>
                                                    <p class="text-success-fg text-xs">Dalam Jaringan Kantor!
                                                    </p>
                                                </template>
                                            </div>
                                        </div>
                                    </CardTitle>
                                    <CardContent class="px-0">
                                        <template v-if="isOnOfficeNetwork">
                                            <div class="flex justify-between items-center">
                                                <Button variant="outline" :loading="ButtonLoading" @click="attend('in')"
                                                    :disabled="attendanceToday?.clock_in"
                                                    class="shadow-sm max-w-[140px] flex-1 px-0 text-success-fg hover:text-success-fg">{{
                                                        attendanceToday?.clock_in ?? 'Absen Masuk' }}</Button>
                                                <EllipsisVertical />
                                                <Button variant="outline" :loading="ButtonLoading"
                                                    @click="attend('out')"
                                                    :disabled="attendanceToday?.clock_out || !attendanceToday?.clock_in"
                                                    class="shadow-sm max-w-[140px] flex-1 px-0 text-danger-fg hover:text-danger-fg">{{
                                                        attendanceToday?.clock_out ?? 'Absen Pulang' }}</Button>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="flex justify-between items-center">
                                                <Button variant="outline"
                                                    class="text-foreground bg-muted max-w-[140px] flex-1 px-0"
                                                    disabled>Absen
                                                    Masuk</Button>
                                                <EllipsisVertical />
                                                <Button variant="outline"
                                                    class="text-foreground bg-muted max-w-[140px] flex-1 px-0"
                                                    disabled>Absen
                                                    Pulang</Button>
                                            </div>
                                        </template>
                                    </CardContent>
                                </CardHeader>
                            </Card>
                            <ActionMenu @toast="callToast" @refresh="refreshPage" />
                        </div>
                        <div class="w-full sm:w-1/2 md:w-full lg:w-1/2 flex flex-col gap-3">
                            <Card class="py-2 gap-1">
                                <CardHeader class="mt-1.5 px-3 md:px-6">
                                    <CardTitle>
                                        <div class="flex justify-between items-center">
                                            <p>Statistik</p>
                                            <p class="font-normal text-muted-foreground text-sm px-2 rounded">
                                                Januari 2026
                                            </p>
                                        </div>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent class="grid grid-cols-2 gap-1.5 text-xs px-6">
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <p class=" text-3xl font-bold">{{ summary.presence }}<span></span></p>
                                            <p>Total Masuk</p>
                                        </CardContent>
                                    </Card>
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <div class="flex items-end space-x-1">
                                                <p class=" text-3xl font-bold">0<span></span></p>
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
                                            <p class=" text-3xl font-bold">6<span></span></p>
                                            <p class="text-nowrap">Sisa Cuti Tahunan</p>
                                        </CardContent>
                                    </Card>
                                    <Card class="py-2">
                                        <CardContent class="px-4">
                                            <p class=" text-3xl font-bold">{{ summary.late }}<span></span></p>
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
                                            <div class="flex space-x-1">
                                                <p v-for="(badge, index) in badges" :key="index"
                                                    class="font-normal text-sm px-3 py-0.5 rounded-lg"
                                                    :class="badge.class">
                                                    {{ badge.label }}
                                                </p>
                                            </div>
                                        </div>
                                    </CardTitle>
                                </CardHeader>
                                <div class="min-h-0 flex-1 flex flex-col px-6 gap-1.5 text-xs "
                                    v-if="firstHistoryEntry">
                                    <p>{{ today }}</p>
                                    <simplebar data-simplebar-auto-hide="true" class="min-h-0 flex flex-col flex-1">
                                        <div class="flex flex-col gap-1.5">
                                            <div v-if="firstHistoryEntry.isToday"
                                                v-for="(item, index) in firstHistoryEntry.items" :key="item.id"
                                                class="flex gap-3">
                                                <p class="p-0.5 rounded-4xl rounded-l-none"
                                                    :class="index % 2 === 0 ? 'bg-amber' : 'bg-rose'">
                                                </p>
                                                <p class="py-0.5 min-w-[30px]">{{ formatTime(item.created_at) }}</p>
                                                <p class="py-0.5">:</p>
                                                <p class="py-0.5">{{ item.description }}</p>
                                            </div>
                                            <template v-else>
                                                <p class="text-center py-2">Belum ada keterangan hari ini</p>
                                            </template>
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
                <UserAttendance />
            </div>
        </div>

    </AppLayout>
</template>
