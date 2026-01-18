<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import simplebar from 'simplebar-vue'
import { Building, CalendarPlus, Check, CheckCheck, CircleCheck, Clock, ClockPlus, List } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { useListApproval } from '@/composables/useListApproval'
import { useForm } from '@inertiajs/vue3'
import { toastSuccess } from '@/services/ToastService'
const { list_approval, fetchListApproval } = useListApproval()
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
    fetchListApproval()
    updateDateTime()
    setInterval(updateDateTime, 1000) // Update tiap detik
})

const categoryConfig = {
    duty: {
        desc: 'Detail employee request duty',
        border: 'border-ocean border-t-10',
        color: 'bg-ocean',
        icon: Building,
        label: 'Tujuan',
        ket: 'Lama Izin'
    },
    permission: {
        desc: 'Detail employee request permission',
        border: 'border-rose border-t-10',
        color: 'bg-rose',
        icon: CalendarPlus,
        label: 'Cuti',
        ket: 'Lama Izin'
    },
    overtime: {
        desc: 'Detail employee request overtime',
        border: 'border-tangerine border-t-10',
        color: 'bg-tangerine',
        icon: ClockPlus,
        label: 'Hari',
        ket: 'Jam'
    },
    default: {
        desc: 'General employee request information',
        border: 'border-gray border-t-10',
        color: 'gray',
        icon: Clock,
        label: 'Info',
        ket: '-'
    }
}

const dayDiff = (start: string, end: string): string => {
    const startDate = new Date(start)
    const endDate = new Date(end)

    const diff =
        Math.ceil(
            (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24)
        ) + 1

    return `${diff} Hari`
}

const getDay = (date: string): string => {
    const [year, month, day] = date.split('-').map(Number)

    const d = new Date(year, month - 1, day)

    return d.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    })
}

const formatTime = (time: string): string => {
    return time.slice(0, 5)
}

const getFirstName = (fullName: string): string => {
    return fullName.trim().split(' ')[0]
}

const categoryData = (item: any) => {
    if (item.category === 'duty') {
        return {
            primary: item.purpose,
            secondary: dayDiff(item.start_date, item.end_date)
        }
    }

    if (item.category === 'permission') {
        return {
            primary: item.type,
            secondary: dayDiff(item.start_date, item.end_date)
        }
    }

    if (item.category === 'overtime') {
        return {
            primary: getDay(item.date),
            secondary: `${formatTime(item.start_at)} - ${formatTime(item.end_at)}`
        }
    }

    return {
        primary: '-',
        secondary: '-'
    }
}

const getCategoryConfig = (category: any) => {
    return categoryConfig[category as keyof typeof categoryConfig]
        ?? categoryConfig.default
}

const activeMenu = ref(null) as any

// 4️⃣ Submit
const form = useForm({
    id: '',
    category: '',
    user_id: ''
})

function handleApprove(item: any) {
    activeMenu.value = null;
    form.id = item.id
    form.category = item.category
    form.user_id = item.user.id

    form.post(route('admin.request.approve'), {
        onSuccess: () => {
            toastSuccess('Berhsail di setujui')
            fetchListApproval()
        },
        onError: (errors) => {
            console.log('Ada error validasi ❌', errors)
        },
    })
}

</script>

<template>
    <div class="flex justify-between">
        <p class="text-lg font-extrabold">Approval</p>
    </div>
    <simplebar data-simplebar-auto-hide="true" class="flex overflow-y-auto min-h pr-5 mb-3">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2 lg:text-sm text-xs " v-for="(request, label) in list_approval">
                <p class="font-bold">{{ label }}</p>
                <template v-for="item in request">
                    <div class="flex flex-col gap-1 rounded-lg px-4 py-2 text-white flex-1 max-w-full"
                        :class="getCategoryConfig(item.category).color">
                        <div class="flex justify-between ">
                            <div class="flex space-x-3">
                                <Avatar class="size-6">
                                    <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                                    <AvatarFallback>CN</AvatarFallback>
                                </Avatar>
                                <p class="font-bold text-base">{{ getFirstName(item.user.name) }}</p>
                            </div>
                            <component :is="getCategoryConfig(item.category).icon" :size="25" class="text-white" />
                        </div>
                        <div class="text-sm font-bold">
                            <p class="line-clamp-1"><span class=" font-normal text-white/75 mr-1">{{
                                getCategoryConfig(item.category).label }} :</span> {{ categoryData(item).primary }}
                            </p>
                            <p v-if="item.status == 'pending'"><span class=" font-normal text-white/75 mr-1">{{ getCategoryConfig(item.category).ket
                            }}:</span>{{ categoryData(item).secondary }}</p>
                        </div>
                        <div class="flex justify-end space-x-2 items-center mt-1">
                            <div class="flex items-center " v-if="item.status == 'approved'">
                                <CircleCheck :size="19" />
                            </div>
                            <Button size="sm" class="text-white h-7 cursor-pointer border-0" @click="activeMenu = item"
                                :class="getCategoryConfig(item.category).color" variant="outline">
                                <list />
                                <p class="text-sm font-bold">Detail</p>
                            </Button>
                            <Button v-if="item.status == 'pending'" size="sm"
                                class="text-foreground bg-sand h-7 cursor-pointer hover:bg-sand/50"
                                :loading="form.processing" @click="handleApprove(item)">
                                <p class="text-sm font-bold">Approve</p>
                            </Button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </simplebar>

    <Dialog :open="!!activeMenu" @update:open="val => !val && (activeMenu = null)">
        <DialogContent v-if="activeMenu" class="sm:max-w-xl" :class="getCategoryConfig(activeMenu.category).border">
            <DialogHeader class="min-w-0">
                <DialogTitle class=" capitalize">
                    {{ activeMenu.user.name }} - {{ activeMenu.category }} <p class="text-forest mt-1" v-if="activeMenu.status == 'approved'" >Approved</p>
                </DialogTitle>
                <DialogDescription>
                    {{ getCategoryConfig(activeMenu.category).desc }}
                </DialogDescription>
            </DialogHeader>
            <div class="flex flex-col gap-1">
                <div class="flex space-x-2">
                    <p class="text-muted-foreground">{{ getCategoryConfig(activeMenu.category).label }}</p>
                    <p>:</p>
                    <p>{{ categoryData(activeMenu).primary }}</p>
                </div>
                <div class="flex space-x-2">
                    <p class="text-muted-foreground">{{ getCategoryConfig(activeMenu.category).ket }}</p>
                    <p>:</p>
                    <p>{{ categoryData(activeMenu).secondary }}</p>
                </div>
                <div class="flex flex-col space-x-2">
                    <p class="text-muted-foreground">Deskripsi</p>
                    <p>{{ activeMenu.description }}</p>
                </div>
            </div>
            <div class="flex justify-end space-x-2" v-if="activeMenu.status == 'pending'">
                <Button size="sm" class="text-white h-8 cursor-pointer border-0" variant="destructive">
                    <p class="text-sm font-bold">Reject</p>
                </Button>
                <Button  size="sm"
                    class="text-white  h-8 cursor-pointer hover:bg-muted hover:text-foreground" :class="getCategoryConfig(activeMenu.category).color" :loading="form.processing"
                    @click="handleApprove(activeMenu)">
                    <p class="text-sm font-bold">Approve</p>
                </Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
