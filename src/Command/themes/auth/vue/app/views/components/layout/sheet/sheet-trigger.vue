<script setup>
import { DialogTrigger } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <DialogTrigger v-bind="props">
        <slot />
    </DialogTrigger>
</template>
