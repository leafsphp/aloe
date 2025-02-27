<script setup>
import { Breadcrumbs } from '@/components/shared/breadcrumbs';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/shared/avatar';
import { Button } from '@/components/form/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/shared/dropdown-menu';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/layout/sidebar';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/layout/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/layout/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/shared/tooltip';
import UserMenuContent from '@/components/layout/user-menu-content.vue';
import { getInitials } from '@/utils';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, ChevronsUpDown, Folder, LayoutGrid, Menu, Search } from 'lucide-vue-next';
import { computed } from 'vue';
import { Primitive } from 'radix-vue';

defineProps({
    variant: {
        type: String,
        default: 'sidebar',
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
    showEmail: {
        type: Boolean,
        default: true,
    },
});

const page = usePage();
const auth = computed(() => page.props.auth);

const isCurrentRoute = (url) => {
    return page.url === url;
};

const activeItemStyles = computed(() => (url) => (isCurrentRoute(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''));

const mainNavItems = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

const rightNavItems = [
    {
        title: 'Repository',
        href: 'https://github.com/leafsphp/leaf',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://leafphp.dev',
        icon: BookOpen,
    },
];
</script>

<template>
    <div v-if="variant === 'header'">
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                LOGO
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <Link v-for="item in mainNavItems" :key="item.title" :href="item.href"
                                        class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                        :class="activeItemStyles(item.href)">
                                    <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                    {{ item.title }}
                                    </Link>
                                </nav>
                                <div class="flex flex-col space-y-4">
                                    <a v-for="item in rightNavItems" :key="item.title" :href="item.href" target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium">
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link href="/dashboard" class="flex items-center gap-x-2">LOGO</Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem v-for="(item, index) in mainNavItems" :key="index"
                                class="relative flex h-full items-center">
                                <Link :href="item.href">
                                <NavigationMenuLink
                                    :class="[navigationMenuTriggerStyle(), activeItemStyles(item.href), 'h-9 cursor-pointer px-3']">
                                    <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4" />
                                    {{ item.title }}
                                </NavigationMenuLink>
                                </Link>
                                <div
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white">
                                </div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>


                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer">
                            <Search class="size-5 opacity-80 group-hover:opacity-100" />
                        </Button>

                        <div class="hidden space-x-1 lg:flex">
                            <template v-for="item in rightNavItems" :key="item.title">
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button variant="ghost" size="icon" as-child
                                                class="group h-9 w-9 cursor-pointer">
                                                <a :href="item.href" target="_blank" rel="noopener noreferrer">
                                                    <span class="sr-only">{{ item.title }}</span>
                                                    <component :is="item.icon"
                                                        class="size-5 opacity-80 group-hover:opacity-100" />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button variant="ghost" size="icon"
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary">
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar"
                                        :alt="auth.user.name" />
                                    <AvatarFallback
                                        class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div v-if="breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>

    <Sidebar v-else collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/">LOGO</Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <div data-sidebar="group" class="relative flex w-full min-w-0 flex-col px-2 py-0">
                <Primitive data-sidebar="group-label" class="flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-sidebar-foreground/70 outline-none ring-sidebar-ring transition-[margin,opa] duration-200 ease-linear focus-visible:ring-2 [&>svg]:size-4 [&>svg]:shrink-0 group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0">Platform</Primitive>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in mainNavItems" :key="item.title">
                        <SidebarMenuButton as-child :is-active="item.href === page.url">
                            <Link :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </div>
        </SidebarContent>

        <SidebarFooter>
            <div data-sidebar="group"
                class="relative flex w-full min-w-0 flex-col p-2 group-data-[collapsible=icon]:p-0">
                <div data-sidebar="group-content" class="w-full text-sm">
                    <SidebarMenu data-sidebar="group-content" class="w-full text-sm">
                        <SidebarMenuItem v-for="item in rightNavItems" :key="item.title">
                            <SidebarMenuButton
                                class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
                                as-child>
                                <a :href="item.href" target="_blank" rel="noopener noreferrer">
                                    <component :is="item.icon" />
                                    <span>{{ item.title }}</span>
                                </a>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </div>
            </div>

            <SidebarMenu>
                <SidebarMenuItem>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <SidebarMenuButton size="lg"
                                class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                                <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar"
                                        :alt="auth.user.name" />
                                    <AvatarFallback class="rounded-lg text-black dark:text-white">
                                        {{ getInitials(auth.user.name) }}
                                    </AvatarFallback>
                                </Avatar>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-medium">{{ auth.user.name }}</span>
                                    <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{
                                        auth.user.email
                                    }}</span>
                                </div>
                                <ChevronsUpDown class="ml-auto size-4" />
                            </SidebarMenuButton>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                            side="bottom" align="end" :side-offset="4">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarFooter>
    </Sidebar>
</template>
