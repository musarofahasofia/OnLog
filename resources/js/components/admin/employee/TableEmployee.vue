<script setup lang="ts">
import type { ColumnDef, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table'
import {
    FlexRender, getCoreRowModel, getExpandedRowModel, getFilteredRowModel,
    getPaginationRowModel, getSortedRowModel, useVueTable,
} from '@tanstack/vue-table'
import { h, ref } from 'vue'
import { createReusableTemplate } from '@vueuse/core'
import { ArrowUpDown, ChevronDown, MoreHorizontal, MoreVertical, PenBox, Plus, Trash } from 'lucide-vue-next'
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
import AddEmployee from './AddEmployee.vue'
import { useToast } from "vue-toastification";
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/components/ui/avatar'
import { User } from '@/types'
import { useStatus } from '@/composables/useStatus'

const { getBadgeStyles } = useStatus()
export interface Payment {
    id: string
    amount: number
    status: 'pending' | 'processing' | 'success' | 'failed'
    email: string
}
const addDialog = ref(false)
const is_edit = ref(false)
const data_row = ref<User | null>()
const toast = useToast();

function onEditClick(row: User) {
  is_edit.value = true
  data_row.value = { ...row } // clone biar aman
  addDialog.value = true
}

function onCreateClick() {
  is_edit.value = false
  data_row.value = null
  addDialog.value = true
}

function callToast(type: "success" | "error" | "info" | "warning", message: string) {
    const toastMap = {
        success: toast.success,
        error: toast.error,
        info: toast.info,
        warning: toast.warning,
    };

    toastMap[type]?.(message);
}

const emit = defineEmits(['refresh'])

const props = withDefaults(
    defineProps<{
        users?: User[]
    }>(),
    {
        users: () => [],
    }
)

const [DefineTemplate, ReuseTemplate] = createReusableTemplate<{
    user: User,
    onExpand: () => void
}>()

const columns: ColumnDef<User>[] = [
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
        accessorKey: 'name',
        header: 'Nama',
        cell: ({ row }) => h(
            'div',
            { class: 'flex items-center space-x-3 capitalize' },
            [
                h(
                    Avatar,
                    { class: 'size-8' },
                    {
                        default: () => [
                            h(AvatarImage, {
                                class: "object-cover object-center w-full h-full",
                                src: row.original.photo,
                            }),
                            h(
                                AvatarFallback,
                                {},
                                () => row.original.name.charAt(0)
                            ),
                        ],
                    }
                ),
                h('span', {}, row.getValue('name')),
            ]
        ),
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                class: 'has-[>svg]:px-0',
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email')),
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.original.badge_status

            const badges = getBadgeStyles(status)

            return h(
                'div',
                { class: 'flex gap-1' },
                badges.map(badge =>
                    h(
                        'p',
                        {
                            class: [
                                'font-normal text-sm px-3 py-0.5 rounded-lg',
                                badge.class,
                            ],
                        },
                        badge.label
                    )
                )
            )
        },
    },
    {
        accessorKey: 'jabatan',
        header: 'Jabatan',
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.original.jabatan),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const user = row.original

            return h(ReuseTemplate, {
                user,
                onExpand: row.toggleExpanded,
            })
        },
    },
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable<User>({
    data: props.users,
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
    <DefineTemplate v-slot="{ user }">
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <div class="w-full flex-1 flex justify-end">
                    <Button variant="ghost" class="h-6 w-8 p-0">
                        <span class="sr-only">Open menu</span>
                        <MoreVertical class="h-4 w-4" />
                    </Button>
                </div>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuItem @click="onEditClick(user)">
                    <PenBox/> Edit
                </DropdownMenuItem>
                <!-- <DropdownMenuItem @click="" class="text-coral">
                   <Trash class="text-coral"/> Hapus
                </DropdownMenuItem> -->
            </DropdownMenuContent>
        </DropdownMenu>
    </DefineTemplate>
    <div class="flex-1 overflow-x-auto w-full">
        <div class="flex justify-between items-center py-4">
            <Input class="max-w-sm" placeholder="Filter emails..."
                :model-value="table.getColumn('email')?.getFilterValue() as string"
                @update:model-value=" table.getColumn('email')?.setFilterValue($event)" />
            <div class="flex gap-4">
                <Button variant="secondary" @click="onCreateClick()"
                    class="ml-auto bg-abyss/60 text-white hover:bg-abyss/30 cursor-pointer border ">
                    <Plus />
                    Karyawan
                </Button>
            </div>
        </div>
        <div class="max-w-full border rounded-lg overflow-hidden overflow-x-auto">
            <Table>
                <TableHeader class="overflow-hidden">
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
                    <DialogTitle>Tambah Karyawan</DialogTitle>
                    <DialogDescription>
                        Isi formulir berikut untuk mendaftarkan karyawan baru.
                    </DialogDescription>
                </DialogHeader>
                <AddEmployee @close="addDialog = false" @toast="callToast" @refresh="emit('refresh')" :is_edit="is_edit" :user="data_row" />
            </DialogContent>
        </template>
    </Dialog>
</template>
