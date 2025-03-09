<script setup>
import { onMounted, ref } from 'vue';
import { SidebarProvider, SidebarInset, SidebarTrigger } from '@/components/layout/sidebar';
import { Breadcrumbs } from '@/components/shared/breadcrumbs';
import AppHeader from '@/components/layout/app-header.vue';

defineProps({
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
    variant: {
        type: String,
        default: 'sidebar',
    },
    className: {
        type: String,
        default: '',
    },
});

const isOpen = ref(true);

onMounted(() => {
    isOpen.value = localStorage.getItem('sidebar') !== 'false';
});

const handleSidebarChange = (open) => {
    isOpen.value = open;
    localStorage.setItem('sidebar', String(open));
};
</script>

<template>
    <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
        <AppHeader variant="header" :breadcrumbs="breadcrumbs" />
        <main class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl" :class="className">
            <slot />
        </main>
    </div>
    <SidebarProvider v-else :default-open="isOpen" :open="isOpen" @update:open="handleSidebarChange">
        <AppHeader variant="sidebar" :breadcrumbs="breadcrumbs" />
        <SidebarInset :class="className">
            <header
                className="border-sidebar-border/50 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
                <div className="flex items-center gap-2">
                    <SidebarTrigger className="-ml-1 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0" />
                    <Breadcrumbs :breadcrumbs="breadcrumbs" />
                </div>
            </header>
            <slot />
        </SidebarInset>
    </SidebarProvider>
</template>
