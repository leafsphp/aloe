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
    <div data-sidebar="header" :class="cn('flex flex-col gap-2 p-2', props.class)">
        <slot />
    </div>
</template>
