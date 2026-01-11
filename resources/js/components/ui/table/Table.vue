<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from "@/lib/utils"
import simplebar from 'simplebar-vue'

const props = defineProps<{
    class?: HTMLAttributes["class"]
}>()
</script>

<template>
    <div data-slot="table-container" class="relative w-full overflow-auto">
        <simplebar class="pb-2">
            <table data-slot="table" :class="cn('w-full caption-bottom text-sm', props.class)">
                <slot />
            </table>
        </simplebar>
    </div>
</template>
