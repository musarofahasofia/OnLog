<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
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
            <p><span class="font-bold">192.168.</span>xxx.xxx</p>
            <p><span class="font-bold">12.167.</span>xxx.xxx</p>
        </CardContent>
    </Card>
</template>
