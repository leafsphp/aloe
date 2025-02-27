<script setup>
import { cn } from '@/utils';
import {
    DropdownMenuContent,
    DropdownMenuPortal,
    useForwardPropsEmits,
} from 'radix-vue';
import { computed } from 'vue';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
    sideOffset: {
        type: Number,
        default: 4,
    },
    side: {
        type: String,
        default: 'bottom',
    },
    align: {
        type: String,
        default: 'start',
    },
});

const emits = defineEmits([
    'escapeKeyDown',
    'pointerDownOutside',
    'focusOutside',
    'interactOutside',
    'closeAutoFocus',
]);

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
    <DropdownMenuPortal>
        <DropdownMenuContent v-bind="forwarded" :class="cn(
            'z-50 min-w-32 overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-md data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
            props.class,
        )
            ">
            <slot />
        </DropdownMenuContent>
    </DropdownMenuPortal>
</template>
