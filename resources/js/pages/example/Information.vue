<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Informasi',
  },
  
];
</script>

<template>
  <AdminAppLayout :breadcrumbs="breadcrumbs">

  </AdminAppLayout>
</template>
