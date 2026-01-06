import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'
import type { Updater } from '@tanstack/vue-table' // Pastikan import dari @tanstack/vue-table
import type { Ref } from 'vue'

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

// Tambahkan fungsi ini untuk Vue
export function valueUpdater<T>(updaterOrValue: Updater<T>, ref: Ref<T>) {
  if (typeof updaterOrValue === 'function') {
    ref.value = (updaterOrValue as (prev: T) => T)(ref.value)
  } else {
    ref.value = updaterOrValue
  }
}
