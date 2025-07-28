<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { type BreadcrumbItem } from '@/types'

// ✅ Props dari controller
const props = defineProps<{ ips: Array<{ id:number, ip_address:string, description:string }> }>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'IP Address',
    href: '/admin/ip-address',
  },
]

// State modal & form
const showForm = ref(false)
const ip_address = ref('')
const description = ref('')

// ✅ Simpan IP baru
function saveIp() {
  router.post('/admin/ip-address', {
    ip_address: ip_address.value,
    description: description.value
  }, {
    onSuccess: () => {
      showForm.value = false
      ip_address.value = ''
      description.value = ''
    }
  })
}

// ✅ Hapus IP
function deleteIp(id:number) {
  router.delete(`/admin/ip-address/${id}`)
}
</script>

<template>
  <AdminAppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 relative">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-purple-700">Manajemen IP Kantor</h1>
        <button @click="showForm = true" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
          + Edit IP
        </button>
      </div>

      <!-- Tabel IP -->
      <div class="bg-white rounded shadow p-4">
        <table class="w-full table-auto">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 text-left">IP Address</th>
              <th class="p-2 text-left">Deskripsi</th>
              <th class="p-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ip in props.ips" :key="ip.id" class="border-b">
              <td class="p-2 font-semibold">{{ ip.ip_address }}</td>
              <td class="p-2">{{ ip.description || '-' }}</td>
              <td class="p-2 text-center">
                <button @click="deleteIp(ip.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
              </td>
            </tr>
            <tr v-if="props.ips.length === 0">
              <td colspan="3" class="p-4 text-center text-gray-500">Belum ada IP kantor.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ✅ Modal Tambah IP -->
      <transition name="fade-slide">
        <div v-if="showForm" class="absolute top-24 left-1/2 transform -translate-x-1/2 bg-white/70 backdrop-blur-md rounded-xl shadow-xl w-full max-w-lg p-6 z-50 border border-white/40">
          <h2 class="text-xl font-bold mb-4">Tambah IP Kantor</h2>
          <form @submit.prevent="saveIp">
            <div class="mb-4">
              <label class="block font-medium mb-1">IP Address</label>
              <input v-model="ip_address" class="w-full border px-3 py-2 rounded bg-white/60" placeholder="contoh: 192.168.1.10" />
            </div>
            <div class="mb-4">
              <label class="block font-medium mb-1">Deskripsi</label>
              <input v-model="description" class="w-full border px-3 py-2 rounded bg-white/60" placeholder="contoh: IP Kantor Pusat" />
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
