import { ref, computed } from 'vue'
import axios from 'axios'

type StatusValue = any

type Badge = {
  label: string
  class: string
}

const status = ref<{ status: StatusValue } | null>(null)

export function useStatus() {
  const fetchStatus = async () => {
    const { data } = await axios.get('status')
    status.value = data.status

  }
  // 🔥 INI KUNCINYA
  const badges = computed<Badge[]>(() => {
    if (!status.value?.status) return []

    if (status.value.status === 'masuk') {
      return [
        {
          label: 'Masuk',
          class: 'text-forest bg-forest/8',
        },
      ]
    }

    if (status.value.status === 'masuk') {
      return [
        {
          label: 'Masuk',
          class: 'text-forest bg-forest/8',
        },
      ]
    }

    if (status.value.status === 'none') {
      return [
        {
          label: 'Absen',
          class: 'text-muted-forground bg-muted',
        },
      ]
    }

    if (status.value.status === 'izin') {
      return [
        {
          label: 'Izin',
          class: 'text-rose bg-rose/8',
        },
      ]
    }

    if (status.value.status === 'lembur') {
      return [
        {
          label: 'Lembur',
          class: 'text-tangerine bg-tangerine/8',
        },
      ]
    }

    if (status.value.status === 'dinas_luar') {
      return [
        {
          label: 'Dinas Luar',
          class: 'text-ocean bg-ocean/8',
        },
      ]
    }

    if (status.value.status === 'terlambat') {
      return [
        {
          label: 'Masuk',
          class: 'text-forest bg-forest/8',
        },
        {
          label: 'Terlambat',
          class: 'text-amber bg-amber/8',
        },
      ]
    }
    return []
  })


  return {
    status,
    badges,
    fetchStatus,
  }
}
