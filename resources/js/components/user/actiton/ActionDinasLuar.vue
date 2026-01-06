<script setup lang="ts">
import { DateFormatter, getLocalTimeZone, today } from '@internationalized/date'
import { CalendarIcon } from 'lucide-vue-next'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Calendar } from '@/components/ui/calendar'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover'
import { ref, watch, shallowRef } from 'vue'
import { Textarea } from '@/components/ui/textarea'
import Input from '@/components/ui/input/Input.vue'

const emit = defineEmits(['close'])
const defaultPlaceholder = today(getLocalTimeZone())
const isLinked = ref(true)

// form input
const start_date = shallowRef(today(getLocalTimeZone())) as any
const end_date = shallowRef(today(getLocalTimeZone())) as any
const tujuan = ref('')
const cuti_desc = ref('')

watch(start_date, (newVal) => {
    if (end_date.value < start_date) {
        isLinked.value = true
    }
    if (isLinked.value) {
        end_date.value = newVal
    }
})

watch(end_date, (newVal, oldVal) => {
    if (newVal !== start_date.value) {
        isLinked.value = false
    }
})

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const handleSubmit = (e: Event) => {
    e.preventDefault() // biar gak reload
    console.log({
        cuti_type: tujuan.value,
        start_date: start_date.value?.toString(),
        end_date: end_date.value?.toString(),
        cuti_desc: cuti_desc.value
    })
}
</script>

<template>
    <form class="flex flex-col space-y-3 min-w-0" @submit="handleSubmit">
        <div class="grid gap-1.5">
            <Label for="cuti_type">Tujuan</Label>
            <Input v-model="tujuan" placeholder="Lokasi tujuan dinas luar" />
        </div>
        <div class="grid gap-1.5">
            <Label>Tanggal Dinas Luar</Label>
            <div class="flex justify-between items-center space-x-3 min-w-0">
                <Popover v-slot="{ close }">
                    <PopoverTrigger as-child>
                        <Button variant="outline"
                            :class="cn('flex-1 justify-start text-left font-normal min-w-0 overflow-hidden', !start_date && 'text-muted-foreground')">
                            <CalendarIcon />
                            <span class="truncate block">
                                {{ start_date ? df.format(start_date.toDate(getLocalTimeZone())) : "Pick a date" }}
                            </span>
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <Calendar v-model="start_date" :default-placeholder="defaultPlaceholder" layout="month-and-year"
                            initial-focus @update:model-value="close" />
                    </PopoverContent>
                </Popover>
                <p>—</p>
                <Popover v-slot="{ close }">
                    <PopoverTrigger as-child>
                        <Button variant="outline"
                            :class="cn('flex-1 justify-start text-left font-normal min-w-0 overflow-hidden ', !end_date && 'text-muted-foreground')">
                            <CalendarIcon />
                            <span class="truncate block">
                                {{ end_date ? df.format(end_date.toDate(getLocalTimeZone())) : "Pick a date" }}
                            </span>
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <Calendar v-model="end_date" :default-placeholder="start_date" layout="month-and-year"
                            :min-value="start_date" initial-focus @update:model-value="close" />
                    </PopoverContent>
                </Popover>
            </div>
        </div>
        <div class="grid gap-1.5">
            <Label>Keperluan</Label>
            <Textarea v-model="cuti_desc" placeholder="Keperluan Dinas Luar" />
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button type="submit" class="bg-amber hover:bg-amber-300 cursor-pointer font-bold">Ajukan Dinas Luar</Button>
        </div>
    </form>
</template>
