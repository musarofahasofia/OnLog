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

const invoices = [
    {
        invoice: 'INV001',
        paymentStatus: 'Paid',
        totalAmount: '$250.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV002',
        paymentStatus: 'Pending',
        totalAmount: '$150.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV003',
        paymentStatus: 'Unpaid',
        totalAmount: '$350.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV004',
        paymentStatus: 'Paid',
        totalAmount: '$450.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV005',
        paymentStatus: 'Paid',
        totalAmount: '$550.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV006',
        paymentStatus: 'Pending',
        totalAmount: '$200.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV007',
        paymentStatus: 'Unpaid',
        totalAmount: '$300.00',
        paymentMethod: 'Credit Card',
    },
]
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
