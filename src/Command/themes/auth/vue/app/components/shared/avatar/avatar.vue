<script setup>
import { cn } from '@/utils';
import { avatarVariant } from '.';
import { AvatarRoot } from 'radix-vue';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
    size: {
        type: String,
        default: 'sm',
    },
    shape: {
        type: String,
        default: 'circle',
    },
});
</script>

<template>
    <AvatarRoot :class="cn(avatarVariant({ size, shape }), props.class)">
        <slot />
    </AvatarRoot>
</template>
