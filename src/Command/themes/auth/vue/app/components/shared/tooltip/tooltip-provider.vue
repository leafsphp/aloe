<script setup>
import { TooltipProvider } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <TooltipProvider v-bind="props">
        <slot />
    </TooltipProvider>
</template>
