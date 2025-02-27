<script setup>
import { Link } from '@inertiajs/vue3';
import Breadcrumb from './breadcrumb.vue';
import BreadcrumbList from './breadcrumb-list.vue';
import BreadcrumbItem from './breadcrumb-item.vue';
import BreadcrumbLink from './breadcrumb-link.vue';
import BreadcrumbPage from './breadcrumb-page.vue';
import BreadcrumbSeparator from './breadcrumb-separator.vue';

defineProps({
    breadcrumbs: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage>{{ item.title }}</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink>
                            <Link :href="item.href ?? '#'">{{ item.title }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
