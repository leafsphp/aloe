<script setup>
import { cn } from '@/utils';
import { Label } from 'radix-vue';
import { computed } from 'vue';

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
    <Label
        v-bind="delegatedProps"
        :class="cn('text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70', props.class)"
    >
        <slot />
    </Label>
</template>
