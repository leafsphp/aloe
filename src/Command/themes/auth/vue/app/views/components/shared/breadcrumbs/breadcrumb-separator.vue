<script setup>
import { cn } from '@/utils';
import { ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <li role="presentation" aria-hidden="true" :class="cn('[&>svg]:h-3.5 [&>svg]:w-3.5', props.class)">
        <slot>
            <ChevronRight />
        </slot>
    </li>
</template>
