<script setup>
defineProps({
    item: Object
});
</script>

<template>
    <AccordionItem :value="item.title" class="border-b-0" v-if="item.items">
        <AccordionTrigger class="text-md py-0 font-semibold hover:no-underline">
            {{ item.title }}
        </AccordionTrigger>
        <AccordionContent class="mt-2">
            <SubMenuLink v-for="subItem in item.items" :key="subItem.title" :item="subItem" />
        </AccordionContent>
    </AccordionItem>

    <a :href="item.url" class="text-md font-semibold" v-else>
        {{ item.title }}
    </a>
</template>
