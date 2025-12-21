<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { useAppearance } from '@/composables/useAppearance';
import { Monitor, Moon, Sun } from 'lucide-vue-next';
import { ref, onMounted, onBeforeUnmount } from 'vue'

const headerRef = ref(null)
let observer: ResizeObserver | null = null

onMounted(() => {
  observer = new ResizeObserver(entries => {
    for (const entry of entries) {
      const height = entry.contentRect.height
      document.documentElement.style.setProperty(
        '--header-h',
        `${height}px`
      )
    }
  })

  if (headerRef.value) {
    observer.observe(headerRef.value)
  }
})

onBeforeUnmount(() => {
  observer?.disconnect()
})

withDefaults(defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
}>(), {
    breadcrumbs: () => []
});



const { appearance, updateAppearance } = useAppearance();

const tabs = [
    { value: 'light', Icon: Sun },
    { value: 'dark', Icon: Moon },
] as const;
</script>

<template>
    <header ref="headerRef"
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
        <div class="flex justify-between flex-1">
            <div class="flex items-center gap-2">
                <SidebarTrigger class="-ml-1" />
                <template v-if="breadcrumbs && breadcrumbs.length > 0">
                    <Breadcrumbs :breadcrumbs="breadcrumbs" />
                </template>
            </div>
            <div class="flex items-center">
                <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800">
                    <button v-for="{ value, Icon } in tabs" :key="value" @click="updateAppearance(value)" :class="[
                        'flex items-center rounded-md px-3.5 py-1.5 transition-colors',
                        appearance === value
                            ? 'bg-white shadow-xs dark:bg-neutral-700 dark:text-neutral-100'
                            : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
                    ]">
                        <component :is="Icon" class="-ml-1 h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
