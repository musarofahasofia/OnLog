<script setup lang="ts">
import type { ColumnDef, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table'
import {
    FlexRender, getCoreRowModel, getExpandedRowModel, getFilteredRowModel,
    getPaginationRowModel, getSortedRowModel, useVueTable,
} from '@tanstack/vue-table'
import { h, ref } from 'vue'
import { createReusableTemplate } from '@vueuse/core'
import { ArrowUpDown, ChevronDown, MoreHorizontal, MoreVertical, Plus } from 'lucide-vue-next'
import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
    DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent,
    DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
    Table, TableBody, TableCell, TableHead,
    TableHeader, TableRow,
} from '@/components/ui/table'
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import AddInformation from './AddInformation.vue'
import simplebar from 'simplebar-vue'

const addDialog = ref(false)
const emit = defineEmits(['refresh'])

export interface Information {
    title: string
    content: string
    type: string
    status: string
    end_date: string
}

const props = withDefaults(
    defineProps<{
        information?: Information[]
    }>(),
    {
        information: () => [],
    }
)


const data: Information[] = [
  {
    title: 'Pengumuman Libur Nasional',
    content: 'Kantor akan tutup pada tanggal 17 Agustus untuk memperingati Hari Kemerdekaan.',
    type: 'pengumuman',
    status: 'aktif',
    end_date: '2026-08-17',
  },
  {
    title: 'Perubahan Jam Kerja',
    content: 'Mulai bulan depan, jam kerja akan dimulai pukul 08.00 hingga 16.00.',
    type: 'kebijakan',
    status: 'nonaktif',
    end_date: '2026-02-01',
  },
  {
    title: 'Pemberitahuan Maintenance Sistem',
    content: 'Sistem akan mengalami downtime sementara pada tanggal 12 Januari 2026.',
    type: 'peringatan',
    status: 'aktif',
    end_date: '2026-01-12',
  },
  {
    title: 'Kegiatan Donor Darah',
    content: 'Akan diadakan kegiatan donor darah di aula utama pada hari Jumat.',
    type: 'kegiatan',
    status: 'aktif',
    end_date: '2026-03-20',
  },
  {
    title: 'Pelatihan Karyawan Baru',
    content: 'Pelatihan akan dilakukan selama dua minggu untuk karyawan baru di departemen IT.',
    type: 'kegiatan',
    status: 'selesai',
    end_date: '2026-01-25',
  },
]

const [DefineTemplate, ReuseTemplate] = createReusableTemplate<{
    payment: {
        id: string
    }
    onExpand: () => void
}>()

const columns: ColumnDef<Information>[] = [
    {
        id: 'select',
        // header: ({ table }) => h(Checkbox, {
        //     'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
        //     'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
        //     'ariaLabel': 'Select all',
        // }),
        // cell: ({ row }) => h(Checkbox, {
        //     'modelValue': row.getIsSelected(),
        //     'onUpdate:modelValue': value => row.toggleSelected(!!value),
        //     'ariaLabel': 'Select row',
        // }),
        // enableSorting: false,
        // enableHiding: false,
    },
    {
        accessorKey: 'title',
        header: 'Judul',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('title')),
    },
    {
        accessorKey: 'content',
        header: 'Konten',
        cell: ({ row }) => h('div', { class: 'capitalize min-w-0 whitespace-normal break-words line-clamp-1' }, row.getValue('content')),
    },
    {
        accessorKey: 'type',
        header: 'Jenis informasi',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('type')),
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('status')),
    },
    {
        accessorKey: 'end_date',
        header: 'Berakhir pada',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('end_date')),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const payment = row.original

            // return h(ReuseTemplate, {
            //     payment,
            //     onExpand: row.toggleExpanded,
            // })
        },
    },
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable<Information>({
    data: props.information,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get expanded() { return expanded.value },
    },
})

function copy(id: string) {
    navigator.clipboard.writeText(id)
}
</script>

<template>
    <DefineTemplate v-slot="{ payment }">
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <div class="w-full flex-1 flex justify-end">
                    <Button variant="ghost" class="h-8 w-8 p-0">
                        <span class="sr-only">Open menu</span>
                        <MoreVertical class="h-4 w-4" />
                    </Button>
                </div>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuItem @click="copy(payment.id)">
                    Copy payment ID
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>View customer</DropdownMenuItem>
                <DropdownMenuItem>View payment details</DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </DefineTemplate>
    <div class="flex-1 overflow-x-auto">
        <div class="flex justify-end items-center py-4">
            <!-- <Input class="max-w-sm" placeholder="Filter emails..."
                :model-value="table.getColumn('email')?.getFilterValue() as string"
                @update:model-value=" table.getColumn('email')?.setFilterValue($event)" /> -->
            <div class="flex gap-4">
                <Button variant="secondary" @click="addDialog = true"
                    class="ml-auto bg-abyss/60 text-white hover:bg-abyss/30 cursor-pointer border ">
                    <Plus />
                    Informasi
                </Button>
            </div>
        </div>
        <div class="max-w-full border rounded-lg overflow-hidden overflow-x-auto">
            <Table class="min-w-full">
                <TableHeader>
                    <TableRow class="" v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead class="bg-abyss/60 text-white " v-for="header in headerGroup.headers"
                            :key="header.id">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length">
                                    {{ JSON.stringify(row.original) }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>

                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            No results.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="space-x-2">
                <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()">
                    Previous
                </Button>
                <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                    Next
                </Button>
            </div>
        </div>
    </div>
    <Dialog v-model:open="addDialog">
        <template v-if="addDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Tambah Informasi</DialogTitle>
                    <DialogDescription>
                        Isi formulir berikut untuk membuat informasi/pengumuman baru
                    </DialogDescription>
                </DialogHeader>
                <AddInformation @refresh="emit('refresh')"/>
            </DialogContent>
        </template>
    </Dialog>
</template>
