<script setup>
defineProps({
    item: Object
});
</script>

<template>
    <a class="flex flex-row gap-4 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none hover:bg-muted hover:text-accent-foreground"
        :href="item.url">
        <div>{{ item.icon }}</div>
        <div>
            <div class="text-sm font-semibold">{{ item.title }}</div>
            <p class="text-sm leading-snug text-muted-foreground" v-if="item.description">
                {{ item.description }}
            </p>
        </div>
    </a>
</template>
