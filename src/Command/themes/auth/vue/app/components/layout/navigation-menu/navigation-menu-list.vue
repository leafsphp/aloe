<script setup>
import { cn } from '@/utils';
import { computed } from 'vue';
import { NavigationMenuList, useForwardProps } from 'radix-vue';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;
    return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
    <NavigationMenuList v-bind="forwardedProps" :class="cn(
        'group flex flex-1 list-none items-center justify-center gap-x-1',
        props.class,
    )
        ">
        <slot />
    </NavigationMenuList>
</template>
