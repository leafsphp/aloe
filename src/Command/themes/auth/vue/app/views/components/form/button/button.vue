<script setup>
import { cn } from '@/utils';
import { Primitive } from 'radix-vue';
import { buttonVariants } from '.';

const props = defineProps({
    as: {
        type: String,
        default: 'button',
    },
    asChild: {
        type: Boolean,
        default: false,
    },
    variant: {
        type: String,
        default: 'default',
    },
    size: {
        type: String,
        default: 'default',
    },
    class: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <Primitive :as="as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), props.class)">
        <slot />
    </Primitive>
</template>
