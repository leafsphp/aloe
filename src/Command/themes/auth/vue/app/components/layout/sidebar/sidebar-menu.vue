<script setup>
import { cn } from '@/utils';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <ul data-sidebar="menu" :class="cn('flex w-full min-w-0 flex-col gap-1', props.class)">
        <slot />
    </ul>
</template>
