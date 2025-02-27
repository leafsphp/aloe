<script>
    import { Link } from "@inertiajs/svelte";

    const { auth } = $props();
</script>

<header
    class="w-full py-2 max-w-7xl mx-auto px-4 flex items-center justify-between"
>
    {#if !auth.user}
        <nav class="-mx-3 flex flex-1 justify-end">
            <Link
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/auth/login">Log in</Link
            >
            <Link
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/auth/register">Register</Link
            >
        </nav>
    {:else}
        <nav class="-mx-3 flex flex-1 justify-end">
            <Link
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                href="/dashboard">Dashboard</Link
            >
        </nav>
    {/if}
</header>
