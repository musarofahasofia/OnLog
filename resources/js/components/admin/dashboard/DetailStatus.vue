<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import { useStatus } from '@/composables/useStatus';
const { getBadgeStyles } = useStatus()
const props = defineProps<{
    data: Record<string, any>
}>()
</script>
<template>
    <div class="rounded-lg overflow-hidden">
        <Table
            class="[&>*>*>th]:px-4 [&>*>*>th]:border-0 [&>*>*>td]:px-4 [&>*>tr:hover]:bg-muted [&>tbody>tr:hover]:bg-muted/50">
            <TableHeader>
                <TableRow class="text-white bg-muted">
                    <TableHead class="w-[100px]">
                        Nama
                    </TableHead>
                    <TableHead>Jabatan</TableHead>
                    <TableHead>Status</TableHead>
                    <!-- <TableHead class="text-right">
                        Total
                    </TableHead> -->
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="user in props.data" :key="user.id">
                    <TableCell class="font-medium">
                        <div class="flex space-x-2 items-center">
                            <Avatar class="size-7">
                                <AvatarImage :src="user.photo ?? ''" alt="@shadcn" class="object-cover object-center w-full h-full" />
                                <AvatarFallback>CN</AvatarFallback>
                            </Avatar>
                            <p>{{ user.name }}</p>
                        </div>
                    </TableCell>
                    <TableCell>{{ user.jabatan }}</TableCell>
                    <TableCell>
                        <div class="flex">
                            <p v-for="badge in getBadgeStyles(user.status.status)"
                                class="font-normal text-sm px-3 py-0.5 rounded-lg" :class="badge.class">
                                {{ badge.label }}
                            </p>
                        </div>
                    </TableCell>
                    <!-- <TableCell class="text-right">
                        {{ user.totalAmount }}
                    </TableCell> -->
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
