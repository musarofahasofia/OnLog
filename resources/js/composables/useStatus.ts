import { ref, computed } from 'vue'
import axios from 'axios'

// 1. Definisikan tipe agar lebih aman (Type Safety)
type StatusKey = 'masuk' | 'none' | 'izin' | 'lembur' | 'dinas_luar' | 'terlambat' | 'new' | 'terlambat_lembur'

export type Badge = {
  label: string
  class: string
}

// 2. Map Konfigurasi Style (Agar tidak perlu banyak IF)
const STATUS_MAP: Record<StatusKey, Badge[]> = {
  masuk: [{ label: 'Masuk', class: 'text-forest bg-forest/8' }],
  none: [{ label: 'Absen', class: 'text-muted-foreground bg-muted' }],
  new: [{ label: 'Absen', class: 'text-muted-foreground bg-muted' }],
  izin: [{ label: 'Izin', class: 'text-rose bg-rose/8' }],
  lembur: [{ label: 'Masuk', class: 'text-forest bg-forest/8' },{ label: 'Lembur', class: 'text-tangerine bg-tangerine/8' }],
  dinas_luar: [{ label: 'Dinas Luar', class: 'text-ocean bg-ocean/8' }],
  terlambat: [
    { label: 'Masuk', class: 'text-forest bg-forest/8' },
    { label: 'Terlambat', class: 'text-amber bg-amber/8' },
  ],
  terlambat_lembur: [
    { label: 'Masuk', class: 'text-forest bg-forest/8' },
    { label: 'Terlambat', class: 'text-amber bg-amber/8' },
    { label: 'Lembur', class: 'text-tangerine bg-tangerine/8' }
  ],
}

// Global state agar bisa di-share antar komponen
const status = ref<{ status: string } | null>(null)

export function useStatus() {
  const fetchStatus = async () => {
    const { data } = await axios.get('status')
    status.value = data.status
  }

  // 3. Fungsi Helper untuk mengambil style berdasarkan param
  // Kamu bisa panggil ini dari frontend langsung
  const getBadgeStyles = (statusVal: string | undefined): Badge[] => {
    if (!statusVal) return []
    return STATUS_MAP[statusVal as StatusKey] || []
  }

  // 4. Computed badges sekarang tinggal memanggil helper di atas
  const badges = computed(() => getBadgeStyles(status.value?.status))

  return {
    status,
    badges,
    fetchStatus,
    getBadgeStyles, // Export fungsi ini agar bisa dipakai manual
  }
}
