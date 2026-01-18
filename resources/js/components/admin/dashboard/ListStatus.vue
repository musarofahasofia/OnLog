<script setup lang="ts">
import { ref, computed } from 'vue'
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
import { AlarmClockCheck, Building, CalendarPlus, ClockArrowUp, ClockPlus, Info, LogIn, Megaphone, NotebookText } from "lucide-vue-next";
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import DetailStatus from './DetailStatus.vue';
const props = defineProps<{
    summary: Record<string, any>
    data: Record<string, any>
}>()


const menus = [
    {
        id: 0,
        title: 'Masuk',
        icon: AlarmClockCheck,
        dialog: {
            title: 'Masuk',
            description: 'List karyawan masuk tepat waktu',
        },
        color: 'bg-forest hover:bg-forest/90',
        karyawan: props.summary.attendance,
        data: props.data.attendance
    },
    {
        id: 1,
        title: 'Izin Cuti',
        icon: CalendarPlus,
        dialog: {
            title: 'Izin Cuti',
            description: 'List karyawan cuti',
        },
        color: 'bg-rose hover:bg-rose/90',
        karyawan: props.summary.permission,
        data: props.data.permission
    },
    {
        id: 2,
        title: 'Dinas Luar',
        icon: Building,
        dialog: {
            title: 'Dinas Luar',
            description: 'List karyawan dinas luar',
        },
        color: 'bg-ocean hover:bg-ocean/90',
        karyawan: props.summary.duty,
        data: props.data.duty
    },
    {
        id: 3,
        title: 'Lembur',
        icon: ClockPlus,
        dialog: {
            title: 'Lembur',
            description: 'List karyawan yang mengajukan lembur',
        },
        color: 'bg-tangerine hover:bg-tangerine/90',
        karyawan: props.summary.overtime,
        data: props.data.overtime
    },
    {
        id: 4,
        title: 'Terlambat',
        icon: ClockArrowUp,
        dialog: {
            title: 'Terlambat',
            description: 'List karyawan yang terlambat',
        },
        color: 'bg-amber hover:bg-amber/90',
        karyawan: props.summary.late,
        data: props.data.late
    },
    {
        id: 4,
        title: 'Absen',
        icon: LogIn,
        dialog: {
            title: 'Absen',
            description: 'List karyawan tidak ada keterangan',
        },
        color: 'bg-coral hover:bg-coral/90',
        karyawan: props.summary.absen,
        data: props.data.absen
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
const avatarMap = computed(() => {
    return menus.map(menu => ({
        ...menu,
        avatars: getAvatars(menu.data),
    }))
})
const activeMenu = ref(null) as any

const extractUsers = (data: any[]) => {
    return data
        .map(item => item.user ?? item) // kalau ada user ambil user, kalau tidak pakai item
        .filter((user, index, self) =>
            self.findIndex(u => u.id === user.id) === index
        ) // deduplicate user
}

const getAvatars = (data: any[]) => {
    const users = extractUsers(data)
    const total = users.length

    if (total <= 3) {
        return {
            items: users,
            remaining: 0,
        }
    }

    return {
        items: users.slice(0, 2),
        remaining: total - 2,
    }
}
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

        <CardContent class="flex flex-col gap-2 px-3 md:px-6">
            <div v-for="menu in menus" :key="menu.id"
                class="@container px-2 rounded py-1.5 grid grid-cols-3 items-center cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md"
                @click="activeMenu = menu">
                <!-- Kolom 1 -->
                <div class="flex items-center gap-4 min-w-0">
                    <div class="p-2 border rounded-lg shrink-0" :class="menu.color">
                        <component :is="menu.icon" :size="20" class="text-white" />
                    </div>
                    <p class="font-bold text-base shrink-0" :title="menu.title">
                        {{ menu.title }}
                    </p>
                </div>

                <!-- Kolom 2: Avatar -->
                <div class="flex justify-center">
                    <div v-if="menu.data.length"
                        class="hidden @[469px]:flex -space-x-2 *:data-[slot=avatar]:ring-background *:data-[slot=avatar]:ring-2">
                        <Avatar v-for="user in getAvatars(menu.data).items" :key="user.id">
                            <AvatarImage :src="user.photo ?? ''" :alt="user.name" class="object-cover object-center w-full h-full" />
                            <AvatarFallback>
                                {{ user.name.slice(0, 2).toUpperCase() }}
                            </AvatarFallback>
                        </Avatar>

                        <Avatar v-if="getAvatars(menu.data).remaining > 0">
                            <AvatarFallback class="text-sm">
                                +{{ getAvatars(menu.data).remaining }}
                            </AvatarFallback>
                        </Avatar>
                    </div>
                </div>

                <!-- Kolom 3 -->
                <div class="flex justify-end text-sm text-muted-foreground items-center">
                    <p class="truncate">
                        <strong class="mr-0.5">{{ menu.karyawan }}</strong> Karyawan
                    </p>
                </div>
            </div>
        </CardContent>
    </Card>

    <Dialog :open="!!activeMenu" @update:open="val => !val && (activeMenu = null)">
        <DialogContent v-if="activeMenu" class="sm:max-w-xl">
            <DialogHeader class="min-w-0">
                <DialogTitle>
                    {{ activeMenu.dialog.title }}
                </DialogTitle>
                <DialogDescription>
                    {{ activeMenu.dialog.description }}
                </DialogDescription>
            </DialogHeader>
            <DetailStatus :data="extractUsers(activeMenu.data)" />
        </DialogContent>
    </Dialog>
</template>
