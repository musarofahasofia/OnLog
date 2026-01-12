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
import { useForm } from '@inertiajs/vue3'

const emit = defineEmits(['close','refresh','toast'])
const defaultPlaceholder = today(getLocalTimeZone())

// form input
const start_date = shallowRef(today(getLocalTimeZone())) as any
const start_time = ref('')
const end_time = ref('')
const desc = ref('')

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const form = useForm({
    date: '',
    start_at: '',
    end_at: '',
    desc: '',
})


const handleSubmit = (e: Event) => {
    e.preventDefault()

    form.date = start_date.value?.toString(),
    form.start_at = start_time.value
    form.end_at = end_time.value
    form.desc = desc.value

    form.post(route('request-overtime.create'), {
        forceFormData: true,
        onSuccess: () => {
            emit('close')
            emit('refresh')
            emit('toast', 'success', 'Berhasil mengajukan lembur')
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
            <Label>Tanggal Lembur</Label>
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
        </div>
        <div class="grid gap-1.5">
            <div class="flex justify-between items-center space-x-3 min-w-0">
                <div class="grid gap-1.5 flex-1">
                    <Label for="start_time">Mulai jam</Label>
                    <Input v-model="start_time" type="time" id="start_time" />
                </div>
                <p class="mt-5">—</p>
                <div class="grid gap-1.5 flex-1">
                    <Label for="start_time">Sampai jam</Label>
                    <Input v-model="end_time" type="time" id="end_time" />
                </div>
            </div>
        </div>
        <div class="grid gap-1.5">
            <Label>Keperluan</Label>
            <Textarea v-model="desc" placeholder="Keperluan Lembur" />
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button type="submit" class="bg-tangerine hover:bg-tangerine-300 cursor-pointer font-bold">Ajukan Lembur</Button>
        </div>
    </form>
</template>
