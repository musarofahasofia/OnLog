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
                    <TableHead class="text-right">
                        Total
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="invoice in invoices" :key="invoice.invoice">
                    <TableCell class="font-medium">
                        <div class="flex space-x-2 items-center">
                            <Avatar class="size-7">
                                <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                                <AvatarFallback>CN</AvatarFallback>
                            </Avatar>
                            <p>{{ invoice.invoice }}</p>
                        </div>
                    </TableCell>
                    <TableCell>{{ invoice.paymentStatus }}</TableCell>
                    <TableCell>{{ invoice.paymentMethod }}</TableCell>
                    <TableCell class="text-right">
                        {{ invoice.totalAmount }}
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
