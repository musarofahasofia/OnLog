<script setup lang="ts">
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardFooter,
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
import { Info, Megaphone } from "lucide-vue-next";
import { ref } from 'vue'
import simplebar from 'simplebar-vue';

const isDialog = ref(false)
const selectedAnnoucement = ref(null) as any
function toggleDialog(item: any) {
    selectedAnnoucement.value = item
    isDialog.value = !isDialog.value
}

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
    <Card v-for="item in announcements" :key="item.id" class="w-70 flex-shrink-0 text-palette-foreground cursor-pointer"
        :class="getCategoryConfig(item.category).color" @click="toggleDialog(item)">
        <CardHeader>
            <CardTitle class="line-clamp-2 pb-1">
                {{ item.title }}
            </CardTitle>

            <CardDescription class="-mt-2 text-palette-foreground">
                {{ item.category }}
            </CardDescription>

            <CardAction class="self-center px-1">
                <component :is="getCategoryConfig(item.category).icon" :size="40" />
            </CardAction>
        </CardHeader>

        <CardContent class="flex-1 flex flex-col justify-between">
            <p class="line-clamp-2">
                {{ item.content }}
            </p>

            <span class="text-sm underline cursor-pointer text-right mt-1">
                baca selengkapnya →
            </span>
        </CardContent>
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
