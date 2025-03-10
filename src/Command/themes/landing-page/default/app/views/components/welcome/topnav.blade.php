<header class="w-full py-2 max-w-7xl mx-auto px-4 flex items-center justify-between">
    <nav class="-mx-3 flex flex-1 justify-end">
        @auth
            <a class="rounded-md px-3 py-2 text-black transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80"
                href="/dashboard">
                Dashboard
            </a>
        @else
            <a class="rounded-md px-3 py-2 text-black transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80"
                href="/auth/login">
                Log in
            </a>
            <a class="rounded-md px-3 py-2 text-black transition hover:text-black/70 focus:outline-none dark:text-white dark:hover:text-white/80"
                href="/auth/register">
                Register
            </a>
        @endif
    </nav>
</header>
