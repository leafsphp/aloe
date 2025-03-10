<script setup>
import { AvatarImage } from 'radix-vue';

const props = defineProps();
</script>

<template>
    <AvatarImage v-bind="props" class="h-full w-full object-cover" />
</template>
