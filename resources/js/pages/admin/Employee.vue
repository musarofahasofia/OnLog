<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { User, type BreadcrumbItem } from '@/types';
import TableEmployee from '@/components/admin/employee/TableEmployee.vue';
import { router } from '@inertiajs/vue3';

const { user } = defineProps<{
  user: User[]
}>()

function refreshPage() {
  router.visit(window.location.href, {
    preserveState: false,
    preserveScroll: true,
    only: ['user'],
  })
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Karyawan',
        href: 'admin/employee',
    },
];
</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">
        <Head title="Karyawan" />

        <div class="@container flex-1 flex">
            <div class="
            flex-1 flex max-w-full w-full justify-between min-h-0 min-w-0
            overflow-hidden
            @[1007px]:h-[calc(100vh-var(--header-h)-17px)]
        ">
                <div class="flex flex-col py-3 px-8 flex-1 overflow-x-auto">
                    <TableEmployee :users="user" @refresh="refreshPage()" />
                </div>
            </div>
        </div>

    </AdminAppLayout>
</template>
