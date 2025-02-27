<script setup>
import { cn } from '@/utils';
import { DropdownMenuLabel, useForwardProps } from 'radix-vue';
import { computed } from 'vue';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
    inset: {
        type: Boolean,
        default: false,
    },
});

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <DropdownMenuLabel v-bind="forwardedProps" :class="cn('px-2 py-1.5 text-sm font-semibold', inset && 'pl-8', props.class)">
        <slot />
    </DropdownMenuLabel>
</template>
