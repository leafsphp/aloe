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
    <li data-sidebar="menu-item" :class="cn('group/menu-item relative', props.class)">
        <slot />
    </li>
</template>
