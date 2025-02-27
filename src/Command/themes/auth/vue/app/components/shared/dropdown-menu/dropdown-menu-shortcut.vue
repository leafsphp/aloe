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
    <span :class="cn('ml-auto text-xs tracking-widest opacity-60', props.class)">
        <slot />
    </span>
</template>
