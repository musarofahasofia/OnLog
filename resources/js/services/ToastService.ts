import { useToast, type ToastInterface } from 'vue-toastification'

let toast: ToastInterface | null = null

export function initToast() {
  if (!toast) {
    toast = useToast()
  }
}

export function toastSuccess(message: string) {
  toast?.success(message)
}

export function toastError(message: string) {
  toast?.error(message)
}

export function toastInfo(message: string) {
  toast?.info(message)
}
