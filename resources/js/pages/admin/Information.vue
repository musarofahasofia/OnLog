<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue'
import { ref } from 'vue'

interface Informasi {
  id: number
  judul: string
  konten: string
  tanggal?: string
}

const informasiList = ref<Informasi[]>([
  { id: 1, judul: 'Meeting Bulanan', konten: 'Meeting bulanan akan diadakan pada 28 Juli 2025', tanggal: '2025-07-20' },
  { id: 2, judul: 'Libur Nasional', konten: 'Tanggal 17 Agustus libur nasional Hari Kemerdekaan.', tanggal: '2025-07-18' }
])

const showForm = ref(false)
const editMode = ref(false)
const formData = ref<Informasi>({ id: Date.now(), judul: '', konten: '' })

function openForm(item?: Informasi) {
  if (item) {
    editMode.value = true
    formData.value = { ...item }
  } else {
    editMode.value = false
    formData.value = { id: Date.now(), judul: '', konten: '' }
  }
  showForm.value = true
}

function saveInformasi() {
  if (editMode.value) {
    const index = informasiList.value.findIndex(i => i.id === formData.value.id)
    if (index !== -1) {
      informasiList.value[index] = { ...formData.value }
    }
  } else {
    informasiList.value.push({
      ...formData.value,
      id: Date.now(),
      tanggal: new Date().toISOString().slice(0, 10)
    })
  }
  showForm.value = false
}

function deleteInformasi(id: number) {
  informasiList.value = informasiList.value.filter(i => i.id !== id)
}
</script>

<template>
  <AdminAppLayout>
    <div class="p-6 relative">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-purple-700">Manajemen Informasi</h1>
        <button @click="openForm()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
          + Tambah Informasi
        </button>
      </div>

      <!-- Tabel Daftar Informasi -->
      <div class="bg-white rounded shadow p-4">
        <table class="w-full table-auto">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">Judul</th>
              <th class="p-2 text-left">Konten</th>
              <th class="p-2 text-left">Tanggal</th>
              <th class="p-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in informasiList" :key="item.id" class="border-b">
              <td class="p-2 font-semibold">{{ item.judul }}</td>
              <td class="p-2">{{ item.konten }}</td>
              <td class="p-2">{{ item.tanggal }}</td>
              <td class="p-2 text-center">
                <button @click="openForm(item)" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded mr-2">
                  Edit
                </button>
                <button @click="deleteInformasi(item.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                  Hapus
                </button>
              </td>
            </tr>
            <tr v-if="informasiList.length === 0">
              <td colspan="4" class="p-4 text-center text-gray-500">Belum ada informasi.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal dengan animasi fade & slide -->
      <transition name="fade-slide">
        <div 
          v-if="showForm" 
          class="absolute top-24 left-1/2 transform -translate-x-1/2 
                 bg-white/70 backdrop-blur-md rounded-xl shadow-xl 
                 w-full max-w-lg p-6 z-50 border border-white/40">

          <h2 class="text-xl font-bold mb-4">{{ editMode ? 'Edit Informasi' : 'Tambah Informasi' }}</h2>

          <form @submit.prevent="saveInformasi">
            <div class="mb-4">
              <label class="block font-medium mb-1">Judul</label>
              <input v-model="formData.judul" class="w-full border px-3 py-2 rounded bg-white/60" />
            </div>
            <div class="mb-4">
              <label class="block font-medium mb-1">Konten</label>
              <textarea v-model="formData.konten" class="w-full border px-3 py-2 rounded bg-white/60" rows="4"></textarea>
            </div>
            <div class="flex justify-end space-x-2">
              <button type="button" @click="showForm=false" class="px-4 py-2 bg-gray-300/70 rounded hover:bg-gray-400/80">Batal</button>
              <button type="submit" class="px-4 py-2 bg-purple-600/90 text-white rounded hover:bg-purple-700/90">Simpan</button>
            </div>
          </form>

        </div>
      </transition>

    </div>
  </AdminAppLayout>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translate(-50%, -10%) scale(0.95);
}

.fade-slide-enter-to {
  opacity: 1;
  transform: translate(-50%, 0) scale(1);
}

.fade-slide-leave-from {
  opacity: 1;
  transform: translate(-50%, 0) scale(1);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translate(-50%, -10%) scale(0.95);
}
</style>
