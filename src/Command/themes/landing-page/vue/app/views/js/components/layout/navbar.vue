<script setup>
import { Link } from '@inertiajs/vue3';
import { NavigationMenu, NavigationMenuList } from "./navigation-menu";
import { Sheet, SheetTrigger, SheetContent, SheetHeader, SheetTitle } from "./sheet";
import MenuItem from "./navbar/menu-item.vue";
import { Button } from "@/components/form/button";

defineProps({
    logo: {
        type: Object,
        default: () => ({
            url: '/',
            src: '#',
            alt: 'logo',
            title: 'LOGO',
        }),
    },
    menu: {
        type: Array,
        default: () => [
            {
                title: 'Pricing',
                url: '/pricing',
            },
            {
                title: 'FAQs',
                url: '#',
            },
        ],
    },
    auth: Object,
});
</script>

<template>
    <header
        class="py-4 fixed top-0 left-0 w-full bg-background shadow-xs dark:shadow-primary-orange/20 z-50 backdrop-blur-2xl backdrop-opacity-20 flex justify-center items-center">
        <div class="container">
            <!-- Desktop Menu -->
            <nav class="hidden justify-between lg:flex">
                <div class="flex items-center gap-6">
                    <a :href="logo.url" class="flex items-center gap-2">
                        <!-- <img :src="logo.src" class="size-5" :alt="logo.alt" /> -->
                        <span class="text-lg font-semibold">
                            {{ logo.title }}
                        </span>
                    </a>
                    <div class="flex items-center">
                        <NavigationMenu>
                            <NavigationMenuList>
                                <MenuItem v-for="item in menu" :key="item.title" :item="item" />
                            </NavigationMenuList>
                        </NavigationMenu>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Button asChild variant="outline" size="sm" v-if="auth.user">
                        <Link href="/dashboard">Dashboard</Link>
                    </Button>
                    <Button asChild variant="outline" size="sm" v-if="!auth.user">
                        <Link href="/auth/login">Login</Link>
                    </Button>
                    <Button asChild size="sm" class="bg-primary-red hover:bg-primary-red/80 text-white"
                        v-if="!auth.user">
                        <Link href="/auth/register">Sign up</Link>
                    </Button>
                </div>
            </nav>
            <!-- Mobile Menu -->
            <div class="block lg:hidden">
                <div class="flex items-center justify-between">
                    <a :href="logo.url" class="flex items-center gap-2">
                        <img :src="logo.src" class="w-8" :alt="logo.alt" />
                        <span class="text-lg font-semibold">
                            {{ logo.title }}
                        </span>
                    </a>
                    <Sheet>
                        <SheetTrigger asChild>
                            <Button variant="outline" size="icon">
                                <Menu class="size-4" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent class="overflow-y-auto">
                            <SheetHeader>
                                <SheetTitle>
                                    <a :href="logo.url" class="flex items-center gap-2">
                                        <img :src="logo.src" class="w-8" :alt="logo.alt" />
                                        <span class="text-lg font-semibold">
                                            {{ logo.title }}
                                        </span>
                                    </a>
                                </SheetTitle>
                            </SheetHeader>
                            <div class="flex flex-col gap-6 p-4">
                                <div class="flex flex-col gap-3">
                                    <Button asChild variant="outline">
                                        <Link href="/auth/login">
                                        Login
                                        </Link>
                                    </Button>
                                    <Button asChild>
                                        <Link href="/auth/register">
                                        Sign up
                                        </Link>
                                    </Button>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </div>
    </header>
</template>
