<script setup lang="ts">
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardFooter,
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
import { Info, Megaphone } from "lucide-vue-next";
import simplebar from 'simplebar-vue';


</script>
<template>
    <simplebar data-simplebar-auto-hide="true" class="overflow-y-auto min-w pb-3">
        <div class="flex gap-5">
            <Dialog>
                <DialogTrigger class="text-left">
                    <Card class="w-70 bg-rose text-palette-foreground cursor-pointer hover:bg-rose/90">
                        <CardHeader>
                            <CardTitle class="line-clamp-2 pb-1">Liburan desember pada tanggal 24 - 28 </CardTitle>
                            <CardDescription class="text-palette-foreground -mt-2">Informasi</CardDescription>
                            <CardAction class="self-center px-1">
                                <Megaphone :size="40" />
                            </CardAction>
                        </CardHeader>
                        <CardContent class="flex-1 flex flex-col justify-between">
                            <p class="line-clamp-2">
                                Ini kan bakal menjadi liburan yang sangat panjang jadi kita harus
                                mempersiapkan berbagai hal dari jauh hari agar semuanya berjalan
                                dengan lancar dan tidak ada kendala selama perjalanan berlangsung.
                            </p>

                            <span class="text-sm underline cursor-pointer text-right mt-1">
                                baca selengkapnya →
                            </span>
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
                    <Card class="w-70 bg-amber text-palette-foreground cursor-pointer hover:bg-amber/90">
                        <CardHeader>
                            <CardTitle class="line-clamp-2 pb-1">Liburan desember pada tanggal 24 - 28 </CardTitle>
                            <CardDescription class="text-palette-foreground -mt-2">Informasi</CardDescription>
                            <CardAction class="self-center px-1">
                                <Info :size="40" />
                            </CardAction>
                        </CardHeader>
                        <CardContent class="flex-1 flex flex-col justify-between">
                            <p class="line-clamp-2">
                                Ini kan bakal menjadi liburan yang sangat panjang jadi kita harus
                                mempersiapkan berbagai hal dari jauh hari agar semuanya berjalan
                                dengan lancar dan tidak ada kendala selama perjalanan berlangsung.
                            </p>

                            <span class="text-sm underline cursor-pointer text-right mt-1">
                                baca selengkapnya →
                            </span>
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
                    <Card class="w-70 bg-rose text-palette-foreground cursor-pointer hover:bg-rose/90">
                        <CardHeader>
                            <CardTitle class="line-clamp-2 pb-1">Liburan desember pada tanggal 24 - 28 </CardTitle>
                            <CardDescription class="text-palette-foreground -mt-2">Informasi</CardDescription>
                            <CardAction class="self-center px-1">
                                <Megaphone :size="40" />
                            </CardAction>
                        </CardHeader>
                        <CardContent class="flex-1 flex flex-col justify-between">
                            <p class="line-clamp-2">
                                Ini kan bakal menjadi liburan yang sangat panjang jadi kita harus
                                mempersiapkan berbagai hal dari jauh hari agar semuanya berjalan
                                dengan lancar dan tidak ada kendala selama perjalanan berlangsung.
                            </p>

                            <span class="text-sm underline cursor-pointer text-right mt-1">
                                baca selengkapnya →
                            </span>
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
        </div>
    </simplebar>
</template>
