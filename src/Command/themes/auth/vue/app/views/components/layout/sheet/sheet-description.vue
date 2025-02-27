<script setup>
import { computed } from 'vue';
import { DialogDescription } from 'radix-vue';
import { cn } from '@/utils';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <DialogDescription :class="cn('text-sm text-muted-foreground', props.class)" v-bind="delegatedProps">
        <slot />
    </DialogDescription>
</template>
