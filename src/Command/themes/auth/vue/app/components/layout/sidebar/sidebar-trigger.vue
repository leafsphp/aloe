<script setup>
import { cn } from '@/utils';
import { PanelLeft } from 'lucide-vue-next';
import { Button } from '@/components/form/button';
import { useSidebar } from './utils';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});

const { toggleSidebar } = useSidebar();
</script>

<template>
    <Button data-sidebar="trigger" variant="ghost" size="icon" :class="cn('h-7 w-7', props.class)" @click="toggleSidebar">
        <PanelLeft />
        <span class="sr-only">Toggle Sidebar</span>
    </Button>
</template>
