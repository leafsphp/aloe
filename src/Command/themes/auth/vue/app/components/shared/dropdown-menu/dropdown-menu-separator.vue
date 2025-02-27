<script setup>
import { cn } from '@/utils';
import { DropdownMenuSeparator } from 'radix-vue';
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
    <DropdownMenuSeparator v-bind="delegatedProps" :class="cn('-mx-1 my-1 h-px bg-muted', props.class)" />
</template>
