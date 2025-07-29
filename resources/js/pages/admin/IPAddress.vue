<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue'
import modalCreate from '@/components/admin/ip/Create.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { type BreadcrumbItem } from '@/types'

// ✅ Props dari controller
const props = defineProps<{ ips: Array<{ id: number, ip_address: string, description: string }> }>()
const openToast = ref(false)

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
function deleteIp(id: number) {
    router.delete(`/admin/ip-address/${id}`)
}
</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 relative">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-purple-700">Manajemen IP Kantor</h1>
                <modalCreate @close="openToast = true"/>
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
                                <button @click="deleteIp(ip.id)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="props.ips.length === 0">
                            <td colspan="3" class="p-4 text-center text-gray-500">Belum ada IP kantor.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
