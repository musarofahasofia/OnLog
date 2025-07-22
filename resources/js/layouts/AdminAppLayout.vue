<script setup lang="ts">
import AppLayout from '@/layouts/app/AdminAppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3'
const page = usePage()



interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />

        <div v-if="page.props.flash?.message" class="p-4 text-green-700 bg-green-100 rounded">
        {{ page.props.flash.message }}
        </div>


    </AppLayout>



</template>
