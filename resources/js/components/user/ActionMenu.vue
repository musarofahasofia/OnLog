<script setup lang="ts">
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"
import { CalendarPlus, Info, Megaphone } from "lucide-vue-next";


</script>
<template>
    <Card class="max-w-100 gap-3 py-4 w-full">
        <CardHeader class="mt-1 px-8">
            <CardTitle>
                <p>Menu</p>
            </CardTitle>
        </CardHeader>
        <CardContent class="flex-1 flex flex-row justify-between gap-3">
            <Dialog>
                <DialogTrigger class="text-left">
                    <Card class="py-2 cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md max-w-[70px]">
                        <CardContent class="px-1">
                            <div class="flex flex-col-reverse justify-between items-center px-3 gap-0.5">
                                <div>
                                    <p class="font-bold text-nowrap text-[10px]">Dinas luar</p>
                                </div>
                                <CalendarPlus :size="30" />
                            </div>
                        </CardContent>
                    </Card>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Are you absolutely sure?</DialogTitle>
                        <DialogDescription>
                            This action cannot be undone. This will permanently delete your account
                            and remove your data from our servers.
                        </DialogDescription>
                    </DialogHeader>
                </DialogContent>
            </Dialog>
            <Dialog>
                <DialogTrigger class="text-left">
                    <Card class="py-2 cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md max-w-[70px]">
                        <CardContent class="px-1">
                            <div class="flex flex-col-reverse justify-between items-center px-3 gap-0.5">
                                <div>
                                    <p class="font-bold text-nowrap text-[10px]">Dinas luar</p>
                                </div>
                                <CalendarPlus :size="30" />
                            </div>
                        </CardContent>
                    </Card>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Are you absolutely sure?</DialogTitle>
                        <DialogDescription>
                            This action cannot be undone. This will permanently delete your account
                            and remove your data from our servers.
                        </DialogDescription>
                    </DialogHeader>
                </DialogContent>
            </Dialog>
            <Dialog>
                <DialogTrigger class="text-left">
                    <Card class="py-2 cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md max-w-[70px]">
                        <CardContent class="px-1">
                            <div class="flex flex-col-reverse justify-between items-center px-3 gap-0.5">
                                <div>
                                    <p class="font-bold text-[10px]">Izin</p>
                                </div>
                                <CalendarPlus :size="30" />
                            </div>
                        </CardContent>
                    </Card>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Are you absolutely sure?</DialogTitle>
                        <DialogDescription>
                            This action cannot be undone. This will permanently delete your account
                            and remove your data from our servers.
                        </DialogDescription>
                    </DialogHeader>
                </DialogContent>
            </Dialog>
            <Dialog>
                <DialogTrigger class="text-left">
                    <Card class="py-2 cursor-pointer hover:bg-muted/50 hover:border-border hover:shadow-md max-w-[70px]">
                        <CardContent class="px-1">
                            <div class="flex flex-col-reverse justify-between items-center px-3 gap-0.5">
                                <div>
                                    <p class="font-bold text-[10px]">Izin</p>
                                </div>
                                <CalendarPlus :size="30" />
                            </div>
                        </CardContent>
                    </Card>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>Are you absolutely sure?</DialogTitle>
                        <DialogDescription>
                            This action cannot be undone. This will permanently delete your account
                            and remove your data from our servers.
                        </DialogDescription>
                    </DialogHeader>
                </DialogContent>
            </Dialog>
        </CardContent>
    </Card>

</template>
