<script setup>
import { DialogRoot, useForwardPropsEmits } from 'radix-vue';

const props = defineProps();
const emits = defineEmits(['open:update']);

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <DialogRoot v-bind="forwarded">
        <slot />
    </DialogRoot>
</template>
