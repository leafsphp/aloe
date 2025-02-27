<script setup>
import Layout from '@/layouts/app-layout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <Layout variant="sidebar" :breadcrumbs="[
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
    ]">
        <div className="py-4 px-4">
            <div className="overflow-hidden shadow-sm sm:rounded-lg bg-black">
                <div className="p-6 text-gray-100">You're logged in!</div>
            </div>
        </div>
    </Layout>
</template>
