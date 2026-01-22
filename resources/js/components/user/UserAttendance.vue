<script setup lang="ts">
import simplebar from 'simplebar-vue';
import { onMounted } from 'vue'
import { useAttendance } from '@/composables/useAttendance'

const { history, fetchHistory, loading } = useAttendance()
const formatTime = (date: string) => {
  return new Date(date).toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
  })
}
onMounted(fetchHistory)
</script>
<template>
    <div class="flex justify-between">
        <p class="text-lg font-extrabold">Riwayat Pengguna</p>
    </div>
    <simplebar data-simplebar-auto-hide="true" class="flex overflow-y-auto min-h pr-1 mb-3">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-3 lg:text-sm text-xs " v-for="(items, dateLabel) in history"
                :key="dateLabel">
                <p class="font-bold">{{ dateLabel }}</p>
                <div v-for="(item, index) in items" :key="item.id" class="flex gap-3">
                    <p class="p-0.5 rounded-4xl rounded-l-none" :class="index % 2 === 0 ? 'bg-amber' : 'bg-rose'"></p>
                    <p class="py-0.5 min-w-[35px]">{{ formatTime(item.created_at) }}</p>
                    <p class="py-0.5">:</p>
                    <p class="py-0.5">{{ item.description }}</p>
                </div>
            </div>
        </div>
    </simplebar>
</template>
