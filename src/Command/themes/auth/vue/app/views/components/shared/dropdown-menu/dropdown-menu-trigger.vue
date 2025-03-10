<script setup>
import { DropdownMenuTrigger, useForwardProps } from 'radix-vue';

const props = defineProps();

const forwardedProps = useForwardProps(props);
</script>

<template>
    <DropdownMenuTrigger class="outline-none" v-bind="forwardedProps">
        <slot />
    </DropdownMenuTrigger>
</template>
