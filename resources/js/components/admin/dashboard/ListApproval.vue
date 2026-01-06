<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import simplebar from 'simplebar-vue'
import { Building, CalendarPlus, List } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
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
</script>

<template>
    <div class="flex justify-between">
        <p class="text-lg font-extrabold">Approval</p>
    </div>
    <simplebar data-simplebar-auto-hide="true" class="flex overflow-y-auto min-h pr-5 mb-3">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2 lg:text-sm text-xs ">
                <p class="font-bold">{{ now }}</p>
                <div class="flex flex-col gap-1 rounded-lg px-4 py-2 bg-ocean text-white flex-1 max-w-full">
                    <div class="flex justify-between ">
                        <div class="flex space-x-3">
                            <Avatar class="size-6">
                                <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                                <AvatarFallback>CN</AvatarFallback>
                            </Avatar>
                            <p class="font-bold text-base">Ibrahim</p>
                        </div>
                        <building :size="25" class="text-white " />
                    </div>
                    <div class="text-sm font-bold">
                        <p class="line-clamp-1"><span class=" font-normal text-white/75 mr-1">Tujuan:</span> Kantor bupat di solo jawa tengah asdf aa</p>
                        <p><span class=" font-normal text-white/75 mr-1">Lama Izin:</span> 2 Hari</p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <Button size="sm" class="text-white bg-ocean h-7 cursor-pointer border-0" variant="outline" >
                            <list/>
                            <p class="text-sm font-bold">Detail</p>
                        </Button>
                        <Button size="sm" class="text-foreground bg-sand h-7 cursor-pointer hover:bg-sand/50">
                            <p class="text-sm font-bold">Approve</p>
                        </Button>
                    </div>
                </div>
                <div class="flex flex-col gap-1 rounded-lg px-4 py-2 bg-rose text-white">
                    <div class="flex justify-between ">
                        <div class="flex space-x-3">
                            <Avatar class="size-6">
                                <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                                <AvatarFallback>CN</AvatarFallback>
                            </Avatar>
                            <p class="font-bold text-base">Ibrahim</p>
                        </div>
                        <CalendarPlus :size="25" class="text-white " />
                    </div>
                    <div class="text-sm font-bold">
                        <p><span class=" font-normal text-white/75 mr-1">Izin:</span> Sakit</p>
                        <p><span class=" font-normal text-white/75 mr-1">Lama Izin:</span> 2 Hari</p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <Button size="sm" class="text-white bg-rose shadow-none h-7 cursor-pointer border-0" variant="outline">
                            <list/>
                            <p class="text-sm font-bold">Detail</p>
                        </Button>
                        <Button size="sm" class="text-foreground bg-sand h-7 cursor-pointer hover:bg-sand/50">
                            <p class="text-sm font-bold">Approve</p>
                        </Button>
                    </div>
                </div>
            </div>

        </div>
    </simplebar>
</template>
