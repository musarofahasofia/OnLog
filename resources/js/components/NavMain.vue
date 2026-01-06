<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from "@/components/ui/avatar"
import {
    Card,
    CardContent,
} from "@/components/ui/card"
import { useSidebar } from './ui/sidebar/utils'

defineProps<{
    items: NavItem[];
}>();

const { open } = useSidebar();
const page = usePage<SharedData>();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <div v-if="open" class="flex flex-col w-full items-center py-8 gap-2">
            <div class="relative inline-block">
                <Avatar class="size-25">
                    <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                    <AvatarFallback>No Image</AvatarFallback>
                </Avatar>
                <div class="absolute z-10 bottom-0 left-1/2 -translate-x-1/2 text-center">
                    <Card class="text-center py-0">
                        <CardContent class="text-xs px-3 text-nowrap">
                            <p>IT Developer</p>
                        </CardContent>
                    </Card>
                </div>
            </div>
            <div class="flex flex-col items-center gap-0.5">
                <p class="font-bold">Mr. Pramudya</p>
                <p class="font-normal text-tangerine bg-tangerine/8 text-sm px-3 py-0.5 rounded-lg">
                    Dinas Luar</p>
            </div>
        </div>
        <div v-if="!open" class="pb-2">
            <Avatar class="size-8">
                <AvatarImage src="https://github.com/shadcn.png" alt="@shadcn" />
                <AvatarFallback>No Image</AvatarFallback>
            </Avatar>
        </div>
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
