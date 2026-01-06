<script setup lang="ts">
import { ref, markRaw } from 'vue'
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { Building, CalendarPlus, ClockArrowUp, Info, Megaphone, NotebookText } from "lucide-vue-next";
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import simplebar from 'simplebar-vue'

const isDialog = ref(false)
const selectedAnnoucement = ref(null) as any
function toggleDialog(item: any) {
    selectedAnnoucement.value = item
    isDialog.value = !isDialog.value
}
const menus = [
    {
        id: 1,
        title: 'Izin Cuti',
        icon: CalendarPlus,
        dialog: {
            title: 'Izin Cuti',
            description: 'Form pengajuan izin cuti karyawan.',
        },
        color: 'bg-rose hover:bg-rose/90',
    },
    {
        id: 2,
        title: 'Dinas Luar',
        icon: Building,
        dialog: {
            title: 'Dinas Luar',
            description: 'Pengajuan tugas dinas luar kantor.',
        },
        color: 'bg-ocean hover:bg-ocean/90',
    },
    {
        id: 3,
        title: 'Lembur',
        icon: ClockArrowUp,
        dialog: {
            title: 'Lembur',
            description: 'Pengajuan lembur karyawan.',
        },
        color: 'bg-tangerine hover:bg-tangerine/90',
    },
    {
        id: 4,
        title: 'Terlambat',
        icon: ClockArrowUp,
        dialog: {
            title: 'Lembur',
            description: 'Pengajuan lembur karyawan.',
        },
        color: 'bg-amber hover:bg-amber/90',
    },
    {
        id: 4,
        title: 'Absen',
        icon: ClockArrowUp,
        dialog: {
            title: 'Lembur',
            description: 'Pengajuan lembur karyawan.',
        },
        color: 'bg-coral hover:bg-coral/90',
    },

    // {
    //     id: 4,
    //     title: 'Slip Gaji',
    //     icon: NotebookText,
    //     dialog: {
    //         title: 'Slip Gaji',
    //         description: 'Lihat dan unduh slip gaji.',
    //     },
    // },
]

// dialog state
const activeMenu = ref(null) as any
const announcements = ref([
    {
        id: 1,
        title: 'Liburan desember pada tanggal 24 - 28',
        category: 'Informasi',
        content: 'Ini kan bakal menjadi liburan yang sangat panjang...',
    },
    {
        id: 2,
        title: 'Liburan desember pada tanggal 24 - 28',
        category: 'Pengumuman',
        content: 'Ini kan bakal menjadi liburan yang sangat panjang...',
    },
    {
        id: 3,
        title: 'Liburan desember pada tanggal 24 - 28',
        category: 'Informasi',
        content: 'Ini kan bakal menjadi liburan yang sangat panjang...',
    },

])

const categoryMap = {
    Informasi: {
        color: 'bg-rose hover:bg-rose/90',
        border: 'border-rose border-t-10',
        icon: Megaphone,
    },
    Pengumuman: {
        color: 'bg-amber hover:bg-amber/90',
        border: 'border-amber border-t-10',
        icon: Info,
    },
    default: {
        color: 'bg-slate hover:bg-slate/90',
        border: 'border-slate border-t-10',
        icon: Info,
    },
} as const

const getCategoryConfig = (category: string) => {
    return categoryMap[category as keyof typeof categoryMap]
        ?? categoryMap.default
}
</script>
<template>
    <Card class="gap-4 min-h-0">
        <CardHeader class="">
            <CardTitle>
                <div class="flex justify-between items-center">
                    <p class="mb-0.5">List Informasi</p>
                </div>
            </CardTitle>
        </CardHeader>

        <simplebar class="flex flex-col overflow-y-auto min-h-0 max-w-full ">
            <CardContent class="flex flex-col gap-2 px-3 md:px-6 text-white">
                <div v-for="menu in announcements" :key="menu.id" :class="getCategoryConfig(menu.category).color"
                    class="px-3 rounded-lg py-2 items-start cursor-pointer hover:border-border hover:shadow-md"
                    @click="toggleDialog(menu)">
                    <!-- Kolom 1: Kiri (ikon + title) -->
                    <div class="flex max-w-full items-start gap-4 ">
                        <component :is="getCategoryConfig(menu.category).icon" :size="45" class="text-white mt-2" />
                        <div class="flex flex-col flex-1">
                            <div class="flex justify-between">
                                <p class="font-bold text-base truncate" :title="menu.title">
                                    {{ menu.title }}
                                </p>
                                <p class="truncate text-sm"> 21 hari</p>
                            </div>
                            <p class=" text-white/90 text-xs">{{ menu.category }}</p>
                            <p class=" text-sm line-clamp-1">{{ menu.content }}</p>
                            <p class=" text-sm text-right underline">→ Lihat Selengkapnya</p>
                        </div>
                    </div>
                </div>
            </CardContent>
        </simplebar>
    </Card>

    <Dialog v-model:open="isDialog">
        <template v-if="selectedAnnoucement">
            <DialogContent :class="getCategoryConfig(selectedAnnoucement.category).border">
                <DialogHeader>
                    <DialogTitle>{{ selectedAnnoucement.title }}</DialogTitle>
                    <DialogDescription>
                        {{ selectedAnnoucement.content }}
                    </DialogDescription>
                </DialogHeader>
            </DialogContent>
        </template>
    </Dialog>
</template>
