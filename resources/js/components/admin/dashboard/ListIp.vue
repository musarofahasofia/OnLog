<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"

const props = defineProps<{
  ips: Record<string, any>
}>()

</script>
<template>
        <Card class="gap-4 ">
        <CardHeader class="">
            <CardTitle>
                <div class="flex justify-between items-center">
                    <p class="mb-0.5">List IP Kantor</p>
                </div>
            </CardTitle>
        </CardHeader>

        <CardContent class="flex flex-col gap-2 px-3 md:px-6 ">
            <p v-for="ip in ips"><span class="font-bold">{{ ip.ip_address }}</span></p>
        </CardContent>
    </Card>
</template>
