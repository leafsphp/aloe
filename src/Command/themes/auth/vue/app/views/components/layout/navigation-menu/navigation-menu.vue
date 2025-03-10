<script setup>
import { cn } from '@/utils';
import { computed } from 'vue';
import { NavigationMenuRoot, useForwardPropsEmits } from 'radix-vue';
import NavigationMenuViewport from './navigation-menu-viewport.vue';

const props = defineProps({
    class: {
        type: String,
        default: '',
    },
});

const emits = defineEmits(['update:modelValue']);

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);
</script>

<template>
  <NavigationMenuRoot
    v-bind="forwarded"
    :class="cn('relative z-10 flex max-w-max flex-1 items-center justify-center', props.class)"
  >
    <slot />
    <NavigationMenuViewport />
  </NavigationMenuRoot>
</template>
