<script setup>
import { computed } from 'vue';
import { cn } from '@/utils';
import { SidebarMenuButtonChild } from '@/components/layout/sidebar';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/shared/tooltip';
import { useSidebar } from './utils';
import { sidebarMenuButtonVariants } from '.';
import { Primitive } from 'radix-vue';

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    variant: {
        type: String,
        default: 'default',
    },
    size: {
        type: String,
        default: 'default',
    },
    as: {
        type: String,
        default: 'button',
    },
    asChild: {
        type: Boolean,
        default: false,
    },
    isActive: {
        type: Boolean,
        default: false,
    },
    class: {
        type: String,
        default: '',
    },
    tooltip: {
        type: [String, Object],
        default: null,
    },
});

const { isMobile, state } = useSidebar();

const delegatedProps = computed(() => {
    const { tooltip, ...delegated } = props;
    return delegated;
});
</script>

<template>
    <Primitive v-if="!tooltip" data-sidebar="menu-button" :data-size="size" :data-active="isActive"
        :class="cn(sidebarMenuButtonVariants({ variant, size }), props.class)" :as="as" :as-child="asChild"
        v-bind="$attrs">
        <slot />
    </Primitive>

    <Tooltip v-else>
        <TooltipTrigger as-child>
            <SidebarMenuButtonChild v-bind="{ ...delegatedProps, ...$attrs }">
                <slot />
            </SidebarMenuButtonChild>
        </TooltipTrigger>
        <TooltipContent side="right" align="center" :hidden="state !== 'collapsed' || isMobile">
            <template v-if="typeof tooltip === 'string'">
                {{ tooltip }}
            </template>
            <component :is="tooltip" v-else />
        </TooltipContent>
    </Tooltip>
</template>
