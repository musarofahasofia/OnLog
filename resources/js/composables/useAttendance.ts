import { ref } from 'vue'
import axios from 'axios'

const history = ref<Record<string, any[]>>({})
const loading = ref(false)
export function useAttendance() {
  const fetchHistory = async () => {
    loading.value = true
    const { data } = await axios.get('/history')
    history.value = data.history
    loading.value = false
  }

  return {
    history,
    loading,
    fetchHistory,
  }
}
