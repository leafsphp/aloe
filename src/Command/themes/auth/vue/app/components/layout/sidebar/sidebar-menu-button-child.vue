<script setup>
import { cn } from '@/utils';
import { Primitive } from 'radix-vue';
import { sidebarMenuButtonVariants } from '.';

const props = defineProps({
    variant: {
        type: String,
        default: 'default',
    },
    size: {
        type: String,
        default: 'default',
    },
    as: {
        type: String,
        default: 'button',
    },
    isActive: {
        type: Boolean,
        default: false,
    },
    asChild: {
        type: Boolean,
        default: false,
    },
    class: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <Primitive
        data-sidebar="menu-button"
        :data-size="size"
        :data-active="isActive"
        :class="cn(sidebarMenuButtonVariants({ variant, size }), props.class)"
        :as="as"
        :as-child="asChild"
        v-bind="$attrs"
    >
        <slot />
    </Primitive>
</template>
