import { ref } from 'vue'
import axios from 'axios'

const list_approval = ref<Record<string, any[]>>({})
const loading = ref(false)
export function useListApproval() {
  const fetchListApproval = async () => {
    loading.value = true
    const { data } = await axios.get('admin/list/approval')
    list_approval.value = data.list
    loading.value = false
  }

  return {
    list_approval,
    loading,
    fetchListApproval,
  }
}
