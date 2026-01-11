<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import TableEmployee from '@/components/admin/employee/TableEmployee.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Karyawan',
        href: 'admin/employee',
    },
];
</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">
        <div class="@container flex-1 flex">
            <div class="
            flex-1 flex max-w-full w-full justify-between min-h-0 min-w-0
            overflow-hidden
            @[1007px]:h-[calc(100vh-var(--header-h)-17px)]
        ">
                <div class="flex flex-col py-3 px-8 flex-1 overflow-x-auto">
                    <TableEmployee />
                </div>
            </div>
        </div>

    </AdminAppLayout>
</template>
