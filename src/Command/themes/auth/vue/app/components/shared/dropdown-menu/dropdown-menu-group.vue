<script setup>
import { DropdownMenuGroup } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <DropdownMenuGroup v-bind="props">
        <slot />
    </DropdownMenuGroup>
</template>
