<script setup>
import {
    NavigationMenuLink,
    useForwardPropsEmits,
} from 'radix-vue';

const props = defineProps();
const emits = defineEmits(["select"]);

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <NavigationMenuLink v-bind="forwarded">
        <slot />
    </NavigationMenuLink>
</template>
