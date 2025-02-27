<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    auth: Object,
});
</script>

<template>
    <header className="w-full py-2 max-w-7xl mx-auto px-4 flex items-center justify-between">
        <nav className="-mx-3 flex flex-1 justify-end" v-if="!auth.user">
            <Link
                className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/auth/login">Log in</Link>
            <Link
                className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/auth/register">Register</Link>
        </nav>
        <nav className="-mx-3 flex flex-1 justify-end" v-else>
            <Link
                className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/dashboard">Dashboard</Link>
        </nav>
    </header>
</template>
