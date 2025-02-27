<script setup>
import { DropdownMenuRadioGroup, useForwardPropsEmits } from 'radix-vue';

const props = defineProps();
const emits = defineEmits(['update:modelValue']);

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <DropdownMenuRadioGroup v-bind="forwarded">
        <slot />
    </DropdownMenuRadioGroup>
</template>
