<script setup>
import { cn } from '@/utils';
import { DialogTitle } from 'radix-vue';
import { computed } from 'vue';

const props = defineProps();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <DialogTitle :class="cn('text-lg font-semibold text-foreground', props.class)" v-bind="delegatedProps">
        <slot />
    </DialogTitle>
</template>
