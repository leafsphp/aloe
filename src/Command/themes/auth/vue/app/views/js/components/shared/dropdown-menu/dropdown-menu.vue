<script setup>
import { DropdownMenuRoot, useForwardPropsEmits } from 'radix-vue';

const props = defineProps({
    defaultOpen: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(['update:open']);
const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <DropdownMenuRoot v-bind="forwarded">
        <slot />
    </DropdownMenuRoot>
</template>
