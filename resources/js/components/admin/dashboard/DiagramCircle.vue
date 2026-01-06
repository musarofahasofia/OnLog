<script setup lang="ts">
import type {
    ChartConfig,
} from "@/components/ui/chart"
import { Donut } from "@unovis/ts"
import { VisDonut, VisSingleContainer } from "@unovis/vue"
import { TrendingUp } from "lucide-vue-next"
import { computed, ref } from "vue"
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import {
    ChartContainer,
    ChartTooltip,
    ChartTooltipContent,
    componentToString,
} from "@/components/ui/chart"

const description = "A simple pie chart"
const total_karyawan = ref(20)

const chartData = [
    { type: "masuk", count: 14 },
    { type: "izin_cuti", count: 2 },
    { type: "dinas_luar", count: 3 },
    { type: "lembur", count: 5 },
    { type: "terlambat", count: 2 },
    { type: "absen", count: 1 },
]
type Data = typeof chartData[number]

const chartConfig = {
    masuk: {
        label: "Masuk",
        color: "var(--color-forest)",
    },
    izin_cuti: {
        label: "Izin / Cuti",
        color: "var(--color-rose)",
    },
    dinas_luar: {
        label: "Dinas Luar",
        color: "var(--color-ocean)",
    },
    lembur: {
        label: "Lembur",
        color: "var(--color-amber)",
    },
    terlambat: {
        label: "Terlambat",
        color: "var(--color-tangerine)",
    },
    absen: {
        label: "Absen",
        color: "var(--color-coral)",
    },
} satisfies ChartConfig

const totalVisitors = computed(() => total_karyawan.value)
const legendItems = computed(() => {
    // 1. Hitung total orang yang secara fisik ada di kantor (Hadir)
    const totalHadir = chartData
        .filter(d => ["masuk"].includes(d.type))
        .reduce((acc, curr) => acc + curr.count, 0)

    const totalData = chartData
        .filter(d => !["lembur", "terlambat"].includes(d.type))
        .reduce((acc, curr) => acc + curr.count, 0)

    return chartData.map((item) => {
        const config = chartConfig[item.type as keyof typeof chartConfig]

        let percentage: string | number

        // 2. Tentukan pembagi (Denominator)
        if (["lembur", "terlambat"].includes(item.type)) {
            // Khusus lembur & terlambat, hitung % dari total yang hadir
            percentage = totalHadir > 0
                ? ((item.count / totalHadir) * 100).toFixed(1)
                : 0
        } else {
            // Sisanya tetap dihitung dari total seluruh karyawan
            percentage = totalData > 0
                ? ((item.count / totalData) * 100).toFixed(1)
                : 0
        }

        return {
            ...item,
            label: config?.label || item.type,
            color: config?.color || '#000000',
            percentage: `${percentage}%`,
            // Tambahkan flag untuk UI jika perlu
            isSubPercentage: ["lembur", "terlambat"].includes(item.type)
        }
    })
})
</script>
<template>
    <Card class="flex flex-col gap-4 ">
        <CardHeader class="items-center pb-0 gap-0">
            <CardTitle>Karyawan</CardTitle>
            <CardDescription>Senin, 19 Januari 2026</CardDescription>
        </CardHeader>
        <CardContent class="flex-1 pb-0">
            <ChartContainer :config="chartConfig" class="mx-auto aspect-square max-h-[200px]" :style="{
                '--vis-donut-central-label-font-size': 'var(--text-3xl)',
                '--vis-donut-central-label-font-weight': 'var(--font-weight-bold)',
                '--vis-donut-central-label-text-color': 'var(--foreground)',
                '--vis-donut-central-sub-label-text-color': 'var(--muted-foreground)',
            }">
                <VisSingleContainer :data="chartData" :margin="{ top: 15, bottom: 15 }">
                    <VisDonut :value="(d: Data) => d.count"
                        :color="(d: Data) => chartConfig[d.type as keyof typeof chartConfig].color" :arc-width="35"
                        :central-label-offset-y="10" :central-label="totalVisitors.toLocaleString()"
                        central-sub-label="Karyawan" />
                    <ChartTooltip :triggers="{
                        [Donut.selectors.segment]: componentToString(chartConfig, ChartTooltipContent, { hideLabel: true, nameKey: 'type' })!,
                    }" />
                </VisSingleContainer>
            </ChartContainer>
        </CardContent>
        <CardFooter class="grid grid-cols-2 gap-y-1 px-6">
            <div v-for="(item, index) in legendItems" :key="item.type"
                class="flex items-start space-x-2 even:flex-row-reverse even:space-x-reverse">
                <span class="w-2.5 h-2.5 mt-1.5 rounded-full shrink-0" :style="{ backgroundColor: item.color }"></span>
                <div class="flex flex-col">
                    <p class="font-medium text-sm">
                        {{ item.label }}
                    </p>
                    <p class="text-xs text-muted-foreground" :class="index % 2 !== 0 ? 'text-right' : ''">
                        {{ item.percentage }} ({{ item.count }})
                    </p>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>
