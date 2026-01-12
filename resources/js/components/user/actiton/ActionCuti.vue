<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import type { DateValue } from '@internationalized/date'
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
import { useForm } from '@inertiajs/vue3'

const emit = defineEmits(['close','refresh','toast'])
const defaultPlaceholder = today(getLocalTimeZone())
const isLinked = ref(true)

// form input
const start_date = shallowRef(today(getLocalTimeZone())) as any
const end_date = shallowRef(today(getLocalTimeZone())) as any
const cuti_type = ref('')
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

const form = useForm({
    type: '',
    start_date: '',
    end_date: '',
    desc: '',
})


const handleSubmit = (e: Event) => {
    e.preventDefault()

    form.type = cuti_type.value,
        form.start_date = start_date.value?.toString(),
        form.end_date = end_date.value?.toString(),
        form.desc = cuti_desc.value

    form.post(route('request-permission.create'), {
        forceFormData: true,
        onSuccess: () => {
            emit('close')
            emit('refresh')
            emit('toast', 'success', 'Berhasil mengajukan izin')
        },
        onError: (errors) => {
            console.log('Ada error validasi ❌', errors)
        },
    })
}
</script>

<template>
    <form class="flex flex-col space-y-3 min-w-0" @submit="handleSubmit">
        <div class="grid gap-1.5">
            <Label>Cuti</Label>
            <Select v-model="cuti_type">
                <SelectTrigger class="w-full">
                    <SelectValue placeholder="Pilih Cuti" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Izin Cuti</SelectLabel>
                        <SelectItem value="Cuti">
                            Cuti
                        </SelectItem>
                        <SelectItem value="Cuti Kehamilan">
                            Cuti Kehamilan
                        </SelectItem>
                        <SelectItem value="Cuti Melahirkan">
                            Cuti Melahirkan
                        </SelectItem>
                        <SelectItem value="Cuti Menikah">
                            Cuti Menikah
                        </SelectItem>
                        <SelectItem value="Cuti Sakit">
                            Cuti Sakit
                        </SelectItem>
                        <SelectItem value="Cuti Unpaid">
                            Cuti Unpaid
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div class="grid gap-1.5">
            <Label>Tanggal Cuti</Label>
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
            <Label>Deskripsi</Label>
            <Textarea v-model="cuti_desc" placeholder="Deskripsi izin cuti" />
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button type="submit" class="bg-rose hover:bg-rose-300 cursor-pointer font-bold">Ajukan izin</Button>
        </div>
    </form>
</template>
