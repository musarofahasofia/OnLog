<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import TableInformation from '@/components/admin/information/TableInformation.vue';
import { Head, router } from '@inertiajs/vue3';

const { information } = defineProps<{
  information: any
}>()

function refreshPage() {
  router.visit(window.location.href, {
    preserveState: false,
    preserveScroll: true,
    only: ['information'],
  })
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Informasi',
        href: 'admin/informasi',
    },
];
</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">
        <Head title="Informasi" />

        <div class="@container flex-1 flex ">
            <div class="
            flex-1 flex max-w-full w-full justify-between min-h-0 min-w-0
            overflow-hidden
            @[1007px]:h-[calc(100vh-var(--header-h)-17px)]
        ">
                <div class="flex flex-col py-3 px-8 flex-1 overflow-x-auto">
                    <TableInformation :information="information" @refresh="refreshPage" />
                </div>
            </div>
        </div>

    </AdminAppLayout>
</template>
