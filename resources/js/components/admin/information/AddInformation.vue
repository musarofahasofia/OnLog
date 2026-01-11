<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { reactive, watch, shallowRef } from 'vue'
import Input from '@/components/ui/input/Input.vue'
import { useForm, useField } from 'vee-validate'
import { z } from 'zod'
import { toTypedSchema } from '@vee-validate/zod'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Calendar } from '@/components/ui/calendar'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover'
import { cn } from '@/lib/utils'
import { CalendarIcon } from 'lucide-vue-next'
import { DateFormatter, getLocalTimeZone, today } from '@internationalized/date'
import type { DateValue } from '@internationalized/date'
import Textarea from '@/components/ui/textarea/Textarea.vue'
// import { computed, onBeforeUnmount } from 'vue'

// const previewUrl = computed(() => {
//   if (!photo.value || !(photo.value instanceof File)) {
//     return undefined
//   }
//   return URL.createObjectURL(photo.value)
// })

// // optional cleanup (penting!)
// onBeforeUnmount(() => {
//   if (previewUrl.value) {
//     URL.revokeObjectURL(previewUrl.value)
//   }
// })

const emit = defineEmits(['close'])

const schema = toTypedSchema(
    z.object({
        title: z.string().min(1, 'judul informasi wajib diisi'),
        type: z.string().min(1, 'Pilih tipe'),
        content: z.string().min(1, 'Wajib diisi secara lengkap'),
        end_date: z
            .custom<DateValue>()
            .refine((val) => val !== null, {
                message: 'Tentukan tanggal akhir',
            }),
    })
)

// 2️⃣ Init form
const { handleSubmit } = useForm({
    validationSchema: schema,
    initialValues: {
        title: '',
        type: '',
        content: '',
        end_date: today(getLocalTimeZone()),
    },
})

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

// 3️⃣ Fields
const { value: title, errorMessage: titleError } = useField<string>('title')
const { value: type, errorMessage: typeError } = useField<string>('type')
const { value: content, errorMessage: contentError } = useField<string>('content')
const { value: endDate, errorMessage: endDateError } = useField<DateValue>('end_date')

// 4️⃣ Submit
const onSubmit = handleSubmit((values) => {
    console.log('VALID 🚀', values)

    const formData = new FormData()
    formData.append('name', values.title)
    formData.append('email', values.type)
    formData.append('password', values.content)
    formData.append(
        'end_date',
        values.end_date.toDate(getLocalTimeZone()).toISOString()
    )

    // axios.post('/api/user', formData)
})

</script>

<template>
    <form class="flex flex-col space-y-3 min-w-0" @submit="onSubmit">
        <div class="grid gap-1.5">
            <Label>Judul</Label>
            <Input v-model="title" placeholder="Judul informasi" />
            <p class="text-coral text-xs/2 ml-1">{{ titleError }}</p>
        </div>
        <div class="flex justify-between gap-3">
            <div class="grid gap-1.5 flex-1">
                <Label>Jenis informasi</Label>
                <Select v-model="type">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Pilih jenis informasi" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Jenis Informasi</SelectLabel>
                            <SelectItem value="informasi">
                                Informasi
                            </SelectItem>
                            <SelectItem value="pengumuman">
                                Pengumuman
                            </SelectItem>
                            <SelectItem value="peringatan">
                                Peringatan
                            </SelectItem>
                            <SelectItem value="kegiatan">
                                Kegiatan
                            </SelectItem>
                            <SelectItem value="kebijakan">
                                Kebijakan
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <p class="text-coral text-xs/2 ml-1">{{ typeError }}</p>
            </div>
            <div class="grid gap-1.5 flex-1">
                <Label>Tanggal Berakhir</Label>
                <Popover v-slot="{ close }">
                    <PopoverTrigger as-child>
                        <Button variant="outline"
                            :class="cn('flex-1 justify-start text-left font-normal min-w-0 overflow-hidden', !endDate && 'text-muted-foreground')">
                            <CalendarIcon />
                            <span class="truncate block">
                                {{ endDate ? df.format(endDate.toDate(getLocalTimeZone())) : "Pick a date" }}
                            </span>
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0">
                        <Calendar v-model="endDate" :default-placeholder="endDate" layout="month-and-year" initial-focus
                            @update:model-value="close" />
                    </PopoverContent>
                </Popover>
            </div>
        </div>
        <div class="grid gap-1.5">
            <Label>Isi informasi</Label>
            <Textarea v-model="content" placeholder="Masukkan isi informasi"></Textarea>
            <p class="text-coral text-xs/2 ml-1">{{ contentError }}</p>
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button type="submit" variant="secondary" class="bg-abyss cursor-pointer font-bold text-white">
                Buat Informasi</Button>
        </div>
    </form>
</template>
