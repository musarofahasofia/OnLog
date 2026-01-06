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
import { AlarmClockCheck, Building, CalendarPlus, ClockArrowUp, Info, Megaphone, NotebookText } from "lucide-vue-next";
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'

const menus = [
    {
        id: 0,
        title: 'Masuk',
        icon: AlarmClockCheck,
        dialog: {
            title: 'Izin Cuti',
            description: 'Form pengajuan izin cuti karyawan.',
        },
        color: 'bg-forest hover:bg-forest/90',
        karyawan: 14
    },
    {
        id: 1,
        title: 'Izin Cuti',
        icon: CalendarPlus,
        dialog: {
            title: 'Izin Cuti',
            description: 'Form pengajuan izin cuti karyawan.',
        },
        color: 'bg-rose hover:bg-rose/90',
        karyawan: 2
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
        karyawan: 3
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
        karyawan: 5
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
        karyawan: 2
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
        karyawan: 1
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

</script>
<template>
    <Card class="gap-4 ">
        <CardHeader class="">
            <CardTitle>
                <div class="flex justify-between items-center">
                    <p class="mb-0.5">List Status Karyawan</p>
                </div>
            </CardTitle>
        </CardHeader>

        <CardContent class="flex flex-col gap-2 px-3 md:px-6 ">
            <div v-for="menu in menus" :key="menu.id"
                class="@container px-2 rounded py-1.5 grid grid-cols-3 items-center cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md"
                @click="activeMenu = menu">
                <!-- Kolom 1: Kiri (ikon + title) -->
                <div class="flex items-center gap-4 min-w-0">
                    <div class="p-2 border rounded-lg shrink-0" :class="menu.color">
                        <component :is="menu.icon" :size="20" class="text-white" />
                    </div>
                    <p class="font-bold text-base shrink-0 " :title="menu.title">
                        {{ menu.title }}
                    </p>
                </div>

                <!-- Kolom 2: Tengah (avatar) -->
                <div class="flex justify-center">
                    <div
                        class="hidden @[469px]:flex -space-x-2 *:data-[slot=avatar]:ring-background *:data-[slot=avatar]:ring-2">
                        <Avatar>
                            <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                            <AvatarFallback>CN</AvatarFallback>
                        </Avatar>
                        <Avatar>
                            <AvatarImage src="https://github.com/leerob.png" alt="@leerob" />
                            <AvatarFallback>LR</AvatarFallback>
                        </Avatar>
                        <Avatar>
                            <AvatarImage src="" alt="@evilrabbit" />
                            <AvatarFallback class="text-sm">12+</AvatarFallback>
                        </Avatar>
                    </div>
                </div>

                <!-- Kolom 3: Kanan (kosong atau tombol lain) -->
                <div class="flex justify-end text-sm text-muted-foreground items-center">
                    <p class="truncate"><strong class="mr-0.5">{{ menu.karyawan }}</strong> Karyawan</p>
                </div>
            </div>
        </CardContent>
    </Card>

    <Dialog :open="!!activeMenu" @update:open="val => !val && (activeMenu = null)">
        <DialogContent v-if="activeMenu">
            <DialogHeader class="min-w-0">
                <DialogTitle>
                    {{ activeMenu.dialog.title }}
                </DialogTitle>
                <DialogDescription>
                    {{ activeMenu.dialog.description }}
                </DialogDescription>
            </DialogHeader>
            <component :is="activeMenu.action" @close="activeMenu = null" />
        </DialogContent>
    </Dialog>
</template>
