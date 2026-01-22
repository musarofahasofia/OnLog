<script setup lang="ts">
import AdminAppLayout from '@/layouts/AdminAppLayout.vue';
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
import { User, type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { AlarmClockCheck, Building, CalendarIcon, CalendarPlus, Clock, LogIn } from 'lucide-vue-next';
import { computed, Ref, ref, watch } from 'vue';
import { useStatus } from '@/composables/useStatus';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { RangeCalendar } from '@/components/ui/range-calendar';
import type { DateRange } from 'reka-ui'
import { getLocalTimeZone, today, toCalendarDate, parseAbsoluteToLocal, CalendarDate } from '@internationalized/date'
import { toastSuccess } from '@/services/ToastService';
import axios from 'axios'

const minValue = new CalendarDate(2026, 1, 1)
const maxValue = today(getLocalTimeZone())
const { data, start_date, end_date } =
    defineProps<{
        data: Record<string, any>,
        start_date: any,
        end_date: any
    }>()

const df = new Intl.DateTimeFormat('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
})

const dateRange = ref<DateRange>({
    start: toCalendarDate(parseAbsoluteToLocal(start_date)),
    end: toCalendarDate(parseAbsoluteToLocal(end_date)),
}) as Ref<DateRange>

const { getBadgeStyles } = useStatus()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Laporan',
        href: 'admin/report',
    },
];

const configRow = {
    attendance: {
        icon: AlarmClockCheck,
        color: 'bg-forest',
        label: 'Hadir',
    },
    permission: {
        icon: CalendarPlus,
        color: 'bg-rose',
        label: 'Izin',
    },
    duty: {
        icon: Building,
        color: 'bg-ocean',
        label: 'Dinas',
    },
    absen: {
        icon: LogIn,
        color: 'bg-coral',
        label: 'Absen',
    }
} as const
type RowType = keyof typeof configRow
type AttendanceItem = {
    id: number
    user: { name: string }
    badge_status: string
    clock_in: string
    clock_out: string
    description: string
    type: RowType
}
const USED_KEYS = ['attendance', 'permission', 'duty', 'absen'] as const
const rowsByDate = computed(() => {
    return Object.entries(data).map(([date, day]) => ({
        date,
        formattedDate: day.formatted_date,
        rows: USED_KEYS.flatMap(type =>
            (day[type] as AttendanceItem[]).map(item => ({
                ...item,
                type
            }))
        )
    }))
})
const formatTime = (time: string): string => {
    return time.slice(0, 5)
}

watch(dateRange, (value) => {
    if (!value?.start || !value?.end) return

    router.get(
        route('admin.report'), // sesuaikan nama route
        {
            start_date: `${value.start.year}-${value.start.month
                .toString()
                .padStart(2, '0')}-${value.start.day
                    .toString()
                    .padStart(2, '0')}`,

            end_date: `${value.end.year}-${value.end.month
                .toString()
                .padStart(2, '0')}-${value.end.day
                    .toString()
                    .padStart(2, '0')}`,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
})

function formatCalendarDate(d: any) {
    if (!d) return ''

    return df.format(
        new Date(d.year, d.month - 1, d.day)
    )
}

const form = useForm({
    start_date: '',
    end_date: '',
})


const isExporting = ref(false);

const handleSubmit = async (e: Event) => {
    e.preventDefault();

    isExporting.value = true;

    try {
        const startDate = `${dateRange.value.start?.year}-${String(dateRange.value.start?.month).padStart(2, '0')}-${String(dateRange.value.start?.day).padStart(2, '0')}`;
        const endDate = `${dateRange.value.end?.year}-${String(dateRange.value.end?.month).padStart(2, '0')}-${String(dateRange.value.end?.day).padStart(2, '0')}`;

        // 2. Request menggunakan Axios
        const response = await axios.get(route('admin.report.export'), {
            params: {
                start_date: startDate,
                end_date: endDate,
            },
            responseType: 'blob',
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;

        const contentDisposition = response.headers['content-disposition'];
        let filename = 'Laporan_Absensi.xlsx';
        if (contentDisposition) {
            const fileNameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
            if (fileNameMatch && fileNameMatch.length === 2)
                filename = fileNameMatch[1];
        }

        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();

        link.remove();
        window.URL.revokeObjectURL(url);

        toastSuccess(`Berhasil ekspor Laporan`);

    } catch (error) {
        console.error(error);
        alert('Gagal mendownload laporan.');
    } finally {
        isExporting.value = false;
    }
}

</script>

<template>
    <AdminAppLayout :breadcrumbs="breadcrumbs">

        <Head title="Laporan" />

        <div class=" flex-1 flex flex-col gap-4 py-5 px-8">
            <div class="flex justify-between">
                <div>
                    <Popover v-slot="{ close }">
                        <PopoverTrigger as-child>
                            <Button variant="outline"
                                :class="cn('flex-1 justify-start text-left font-normal min-w-0 overflow-hidden', !dateRange && ' text-muted-foreground')">
                                <CalendarIcon />
                                <span class="truncate block">
                                    {{ dateRange ? `${formatCalendarDate(dateRange.start)} -
                                    ${formatCalendarDate(dateRange.end)}` : "Pick a date" }}
                                </span>
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-auto p-0">
                            <RangeCalendar v-model="dateRange" class="rounded-md border shadow-sm" :number-of-months="1"
                                :min-value="minValue" :max-value="maxValue" disable-days-outside-current-view />
                        </PopoverContent>
                    </Popover>
                </div>
                <Button variant="secondary" :loading="isExporting" @click="handleSubmit"
                    class="ml-auto bg-abyss/60 text-white hover:bg-abyss/30 cursor-pointer border ">
                    Ekspor Laporan
                </Button>
            </div>
            <template v-for="item in rowsByDate">
                <p>{{ item.formattedDate }}</p>
                <div class="rounded-lg w-full overflow-hidden">
                    <Table
                        class="[&>*>*>th]:px-4 [&>*>*>th]:border-0 [&>*>*>td]:px-4 [&>*>tr:hover]:bg-muted [&>tbody>tr:hover]:bg-muted/50">
                        <colgroup>
                            <col style="width:40px" />
                            <col style="width:250px" />
                            <col style="width:300px" />
                            <col style="width:120px" />
                            <col style="width:120px" />
                            <col />
                        </colgroup>
                        <TableHeader>
                            <TableRow class="text-white bg-muted">
                                <TableHead class="w-10">
                                </TableHead>
                                <TableHead class="">
                                    Nama
                                </TableHead>
                                <TableHead class="w-[230px]">Status</TableHead>
                                <TableHead>Masuk</TableHead>
                                <TableHead>Pulang</TableHead>
                                <TableHead>
                                    Desc
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="row in item.rows">
                                <TableCell class="font-medium py-0">
                                    <div class="p-1 border rounded-lg shrink-0" :class="configRow[row.type].color">
                                        <component :is="configRow[row.type].icon" :size="20" class="text-white" />
                                    </div>
                                </TableCell>
                                <TableCell>{{ row.user.name }}</TableCell>
                                <TableCell class="py-1 w-[230px]">
                                    <div class="flex space-x-1 ">
                                        <p v-for="badge in getBadgeStyles(row.badge_status)"
                                            class="font-normal text-sm px-3 py-0.5 rounded-lg " :class="badge.class">
                                            {{ badge.label }}
                                        </p>
                                    </div>
                                </TableCell>
                                <TableCell>{{ row.clock_in ? formatTime(row.clock_in) : '-' }}</TableCell>
                                <TableCell>{{ row.clock_out ? formatTime(row.clock_out) : '-' }}</TableCell>
                                <TableCell>{{ row.description ?? '-' }}
                                </TableCell>
                            </TableRow>
                        </TableBody>
                        <!-- <TableFooter>
                            <TableRow>
                                <TableCell colspan="5" class="rounded-bl-lg">
                                    Total
                                </TableCell>
                                <TableCell class="text-right rounded-br-lg">
                                    $2,500.00
                                </TableCell>
                            </TableRow>
                        </TableFooter> -->
                    </Table>
                </div>
            </template>
        </div>
    </AdminAppLayout>
</template>
