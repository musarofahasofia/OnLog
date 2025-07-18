<template>
  <form @submit.prevent="submit">
    <div class="mb-4">
      <label class="block mb-1 font-medium">Foto Profil</label>
      <input type="file" @change="handleFile" />
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
      Simpan
    </button>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const file = ref<File | null>(null)

function handleFile(e: Event) {
  const target = e.target as HTMLInputElement
  if (target.files?.length) {
    file.value = target.files[0]
  }
}

function submit() {
  if (!file.value) return

  const formData = new FormData()
  formData.append('photo', file.value)

  router.post('/profile/photo', formData, {
    forceFormData: true,
    onSuccess: () => alert('Foto berhasil diperbarui!')
  })
}
</script>
