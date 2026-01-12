<script setup lang="ts">
import { ref,markRaw } from 'vue'
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
import ActionCuti from './actiton/ActionCuti.vue';
import ActionDinasLuar from './actiton/ActionDinasLuar.vue';
import ActionLembur from './actiton/ActionLembur.vue';
const emit = defineEmits(['close','refresh','toast'])
function callToast(type: "success" | "error" | "info" | "warning", message: string) {
    emit('toast', type , message)
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
        action: markRaw(ActionCuti),
    },
    {
        id: 2,
        title: 'Dinas Luar',
        icon: Building,
        dialog: {
            title: 'Dinas Luar',
            description: 'Pengajuan tugas dinas luar kantor.',
        },
        action: markRaw(ActionDinasLuar),
    },
    {
        id: 3,
        title: 'Lembur',
        icon: ClockArrowUp,
        dialog: {
            title: 'Lembur',
            description: 'Pengajuan lembur karyawan.',
        },
        action: markRaw(ActionLembur),
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
    <Card class="py-2 gap-1">
        <CardHeader class="mt-1.5 px-3 md:px-6">
            <CardTitle>
                <div class="flex justify-between items-center">
                    <p class="mb-0.5">Menu</p>
                </div>
            </CardTitle>
        </CardHeader>

        <CardContent class="grid grid-cols-1 md:grid-cols-2 gap-2 px-3 md:px-6">
            <Card v-for="menu in menus" :key="menu.id"
                class="py-2 cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md"
                @click="activeMenu = menu">
                <CardContent class="px-0">
                    <div class="flex justify-between items-center px-3 gap-0.5">
                        <p class="font-bold text-nowrap text-base/4">
                            {{ menu.title }}
                        </p>

                        <component :is="menu.icon" :size="30" />
                    </div>
                </CardContent>
            </Card>
        </CardContent>
    </Card>

    <Dialog  :open="!!activeMenu" @update:open="val => !val && (activeMenu = null)">
        <DialogContent v-if="activeMenu" >
            <DialogHeader class="min-w-0">
                <DialogTitle>
                    {{ activeMenu.dialog.title }}
                </DialogTitle>
                <DialogDescription>
                    {{ activeMenu.dialog.description }}
                </DialogDescription>
            </DialogHeader>
            <component :is="activeMenu.action" @close="activeMenu = null" @refresh="emit('refresh')" @toast="callToast"/>
        </DialogContent>
    </Dialog>
</template>
