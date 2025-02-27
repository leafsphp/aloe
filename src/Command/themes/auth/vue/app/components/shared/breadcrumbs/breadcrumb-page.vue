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
    <span role="link" aria-disabled="true" aria-current="page" :class="cn('font-normal text-foreground', props.class)">
        <slot />
    </span>
</template>
