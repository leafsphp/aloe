<script setup>
const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <nav aria-label="breadcrumb" :class="props.class">
        <slot />
    </nav>
</template>
