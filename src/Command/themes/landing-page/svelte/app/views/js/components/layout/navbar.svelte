<script>
    import { Link } from "@inertiajs/svelte";
    import Button from "@/components/form/button.svelte";

    const {
        logo = {
            url: "/",
            src: "#",
            alt: "logo",
            title: "LOGO",
        },
        menu = [
            {
                title: "Pricing",
                url: "/pricing",
            },
            {
                title: "FAQs",
                url: "#",
            },
        ],
        auth,
    } = $props();
</script>

<header
    class="py-4 fixed top-0 left-0 w-full bg-background shadow-xs dark:shadow-primary-orange/20 z-50 backdrop-blur-2xl backdrop-opacity-20 flex justify-center items-center"
>
    <div class="container">
        <!-- Desktop Menu -->
        <nav class="hidden justify-between lg:flex">
            <div class="flex items-center gap-6">
                <a href={logo.url} class="flex items-center gap-2">
                    <img src={logo.src} class="size-5" alt={logo.alt} />
                    <span class="text-lg font-semibold">
                        {logo.title}
                    </span>
                </a>
                <div class="flex items-center">
                    <nav
                        aria-label="Main"
                        data-orientation="horizontal"
                        dir="ltr"
                        class="relative z-10 flex max-w-max flex-1 items-center justify-center"
                    >
                        <div style="position: relative;">
                            <ul
                                data-orientation="horizontal"
                                class="group flex flex-1 list-none items-center justify-center space-x-1"
                                dir="ltr"
                            >
                                {#each menu as item}
                                    <a
                                        class="group inline-flex h-10 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-accent-foreground"
                                        href={item.url}>{item.title}</a
                                    >
                                {/each}
                            </ul>
                        </div>
                        <div
                            class="absolute left-0 top-full flex justify-center"
                        ></div>
                    </nav>
                </div>
            </div>
            <div class="flex gap-2">
                {#if auth.user}
                    <Button asChild variant="outline" size="sm">
                        <Link href="/dashboard">Dashboard</Link>
                    </Button>
                {:else}
                    <Button asChild variant="outline" size="sm">
                        <Link href="/auth/login">Login</Link>
                    </Button>
                    <Button
                        asChild
                        size="sm"
                        class="bg-primary-red hover:bg-primary-red/80 text-white"
                    >
                        <Link href="/auth/register">Sign up</Link>
                    </Button>
                {/if}
            </div>
        </nav>
        <!-- Mobile Menu -->
        <div class="block lg:hidden">
            Mobile Menu
        </div>
    </div>
</header>
