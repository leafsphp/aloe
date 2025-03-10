<script setup>
import { AvatarFallback } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <AvatarFallback v-bind="props">
        <slot />
    </AvatarFallback>
</template>
