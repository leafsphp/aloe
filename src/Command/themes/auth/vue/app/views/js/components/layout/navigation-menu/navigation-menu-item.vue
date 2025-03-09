<script setup>
import { NavigationMenuItem } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <NavigationMenuItem v-bind="props">
        <slot />
    </NavigationMenuItem>
</template>
