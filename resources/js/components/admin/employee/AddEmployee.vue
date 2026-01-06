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
import Input from '@/components/ui/input/Input.vue'

const emit = defineEmits(['close'])
const defaultPlaceholder = today(getLocalTimeZone())
const isLinked = ref(true)

// form input
const name = ref('')
const file = ref(undefined)
const email = ref('')
const password = ref('')
const jabatan = ref('')

const handleSubmit = (e: Event) => {
    e.preventDefault() // biar gak reload
    console.log({
        // cuti_type: cuti_type.value,
        // start_date: start_date.value?.toString(),
        // end_date: end_date.value?.toString(),
        // cuti_desc: cuti_desc.value
    })
}
</script>

<template>
    <form class="flex flex-col space-y-3 min-w-0" @submit="handleSubmit">
        <div class="grid gap-1.5">
            <Label>Nama</Label>
            <Input v-model="name" placeholder="Deskripsi izin cuti" />
        </div>
        <div class="grid gap-1.5">
            <Label>Photo profile</Label>
            <Input v-model="file" type="file"  placeholder="Deskripsi izin cuti" />
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button type="submit" class="bg-abyss hover:bg-abyss-300 cursor-pointer font-bold text-white">Ajukan
                izin</Button>
        </div>
    </form>
</template>
