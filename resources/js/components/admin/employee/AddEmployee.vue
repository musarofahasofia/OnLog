<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { reactive, watch, shallowRef } from 'vue'
import Input from '@/components/ui/input/Input.vue'
import { useForm, useField } from 'vee-validate'
import { z } from 'zod'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm as useAPI } from '@inertiajs/vue3'
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
        name: z.string().min(1, 'Nama wajib diisi'),
        email: z.email('Email tidak valid'),
        password: z.string().min(8, 'Minimal 8 karakter'),
        photo: z
            .instanceof(File, { message: 'Foto wajib diupload' })
            .refine(
                (file) => ['image/jpeg', 'image/png'].includes(file.type),
                'Harus JPG / PNG'
            )
            .refine(
                (file) => file.size <= 2 * 1024 * 1024,
                'Maksimal 2MB'
            )
    })
)

// 2️⃣ Init form
const { handleSubmit } = useForm({
    validationSchema: schema,
    initialValues: {
        name: '',
        email: '',
        password: ''
    }
})

// 3️⃣ Fields
const { value: name, errorMessage: nameError } = useField<string>('name')
const { value: email, errorMessage: emailError } = useField<string>('email')
const { value: password, errorMessage: passwordError } = useField<string>('password')
const { value: photo, errorMessage: photoError } = useField<File>('photo')

// 4️⃣ Submit
const form = useAPI({
    name: '',
    email: '',
    password: '',
    photo: undefined
})

const onSubmit = handleSubmit((values) => {
    Object.assign(form, values)

    form.post(route('admin.employee.create'), {
        forceFormData: true
    })
})

// 5️⃣ File handler
const onFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement
    if (!target.files || !target.files.length) {
        photo.value = undefined as any
        return
    }
    photo.value = target.files[0]
}

const generatePassword = (length = 8) => {
  const chars = 'abcdefghijklmnopqrstuvwxyz123456789'
  let password = ''

  for (let i = 0; i < length; i++) {
    password += chars[Math.floor(Math.random() * chars.length)]
  }

  return password
}

const onGeneratePassword = () => {
  password.value = generatePassword(8)
}
</script>

<template>
    <form class="flex flex-col space-y-3 min-w-0" @submit="onSubmit">
        <div class="grid gap-1.5">
            <Label>Nama</Label>
            <Input v-model="name" placeholder="Nama Karyawan" />
            <p class="text-coral text-xs/2 ml-1">{{ nameError }}</p>
        </div>
        <div class="flex justify-between">
            <div class="grid gap-1.5 flex-1">
                <Label>Photo profile</Label>
                <Input type="file" @change="onFileChange" />
                <p class="text-coral text-xs/2 ml-1">{{ photoError }}</p>
            </div>
            <!-- <img v-if="photo" :src="previewUrl" class="w-24 h-24 object-cover rounded" /> -->
        </div>
        <div class="grid gap-1.5">
            <Label>Email</Label>
            <Input v-model="email" placeholder="Email Karyawan" />
            <p class="text-coral text-xs/2 ml-1">{{ emailError }}</p>
        </div>
        <div class="grid gap-1.5">
            <Label>Password</Label>
            <div class="flex space-x-3">
            <Input v-model="password" placeholder="Password Karyawan" />
            <Button type="button" variant="outline" class="cursor-pointer bg-abyss text-white " @click="onGeneratePassword">Generate</Button>
            </div>
            <p class="text-coral text-xs/2 ml-1">{{ passwordError }}</p>
        </div>
        <div class="flex justify-end pt-2 space-x-2">
            <Button type="button" @click="emit('close')"
                class="bg-background hover:bg-muted text-foreground cursor-pointer">Batal</Button>
            <Button :loading="form.processing" type="submit" variant="outline" class="bg-abyss cursor-pointer font-bold text-white">Tambah Karyawan</Button>
        </div>
    </form>
</template>
