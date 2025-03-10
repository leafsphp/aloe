<script setup>
import { NavigationMenuItem, NavigationMenuTrigger, NavigationMenuContent, NavigationMenuLink } from "./../navigation-menu";

defineProps({
    item: Object
});
</script>

<template>
    <NavigationMenuItem v-if="item.items" :key="item.title" class="text-muted-foreground">
        <NavigationMenuTrigger>{{ item.title }}</NavigationMenuTrigger>
        <NavigationMenuContent>
            <NavigationMenuLink asChild v-for="subItem in item.items" :key="subItem.title" class="w-80">
                <SubMenuLink :item="subItem" />
            </NavigationMenuLink>
        </NavigationMenuContent>
    </NavigationMenuItem>

    <a v-else
        class="group inline-flex h-10 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-accent-foreground"
        :href="item.url">
        {{ item.title }}
    </a>
</template>
