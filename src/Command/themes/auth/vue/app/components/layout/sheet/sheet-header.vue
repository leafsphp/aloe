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
    <div :class="cn('flex flex-col gap-y-2 text-center sm:text-left', props.class)">
        <slot />
    </div>
</template>
