<script setup lang="ts">
import { useMagicKeys, whenever } from '@vueuse/core'
import { Dialog, DialogTrigger, DialogClose, DialogContent, DialogOverlay, DialogHeader, DialogTitle, DialogDescription } from '@/components/ui/dialog';
import { ref } from 'vue'
import { MapPinPlus, X } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3'
import Spinner from '@/components/Spinner.vue';

const open = ref(false)
const emit = defineEmits(['close','refresh'])

const form = useForm({
  ip_address: '',
})

const { meta_j } = useMagicKeys()
whenever(meta_j, (n) => {
    if (n)
        open.value = true
})

const submit = () => {
  form.post(route('admin.ip-address.create'), {
    onSuccess: () => {
        open.value = false
    },
    onError: () => {
      console.log('Ada error validasi')
    },
    onFinish: () => {
    }
  })
}
</script>

<template>
    <div>
        <Dialog v-model:open="open">
            <DialogTrigger class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded flex gap-2">
                <MapPinPlus /> Add IP
            </DialogTrigger>
                <DialogOverlay class="bg-background/80 fixed inset-0 z-30" />
                <DialogContent
                    class="fixed top-[40%] left-[50%] max-h-[85vh] w-[90vw] max-w-[24rem] translate-x-[-50%] text-sm rounded-xl overflow-hidden border border-muted-foreground/30 bg-card focus:outline-none z-[100]">
                    <DialogHeader>
                        <DialogTitle>Add IP address</DialogTitle>
                        <DialogDescription>use your office ip address</DialogDescription>
                    </DialogHeader>
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">IP Address</label>
                            <input class="w-full border px-3 py-2 rounded bg-white/60" v-model="form.ip_address"
                                placeholder="contoh: 192.168.1.10" />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="px-4 py-2 bg-gray-300/70 rounded hover:bg-gray-400/80">Batal</button>
                            <button type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 bg-purple-600/90 text-white rounded hover:bg-purple-700/90 flex gap-2 items-center">
                                <Spinner :show="form.processing" />
                                Simpan
                            </button>
                        </div>
                    </form>
                </DialogContent>
        </Dialog>

    </div>
</template>
