<script setup>
import { cn } from '@/utils';
import { Primitive } from 'radix-vue';

const props = withDefaults(defineProps(), {
    as: 'a',
    asChild: false,
    class: '',
});
</script>

<template>
    <Primitive :as="as" :as-child="asChild" :class="cn('transition-colors hover:text-foreground', props.class)">
        <slot />
    </Primitive>
</template>
