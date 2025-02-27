<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: String,
});
</script>

<template>
    <header>
        <h3 class="mb-0.5 text-base font-medium">{{ title }}</h3>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </header>
</template>
