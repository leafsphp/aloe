<script>
    import Header from "@/components/layout/header.svelte";

    const { breadcrumbs, children } = $props();
</script>

<div
    class="group/sidebar-wrapper flex min-h-svh w-full text-sidebar-foreground has-[[data-variant=inset]]:bg-sidebar flex-col"
    style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem;"
>
    <div>
        <Header />

        {#if breadcrumbs?.length > 1}
            <div class="flex w-full border-b border-sidebar-border/70">
                <div
                    class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl"
                >
                    <nav aria-label="breadcrumb" class="">
                        <ol
                            class="flex flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground sm:gap-2.5"
                        >
                            {#each breadcrumbs as breadcrumb, i}
                                {#if i === breadcrumbs.length - 1}
                                    <li
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <span
                                            role="link"
                                            aria-disabled="true"
                                            aria-current="page"
                                            class="font-normal text-foreground"
                                            >{breadcrumb.title}</span
                                        >
                                    </li>
                                {:else}
                                    <li
                                        class="inline-flex items-center gap-1.5"
                                    >
                                        <a
                                            href={breadcrumb.title}
                                            class="transition-colors hover:text-foreground"
                                            >{breadcrumb.title}</a
                                        >
                                    </li>

                                    <li
                                        role="presentation"
                                        aria-hidden="true"
                                        class="[&amp;>svg]:h-3.5 [&amp;>svg]:w-3.5"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-chevron-right-icon"
                                            ><path d="m9 18 6-6-6-6"
                                            ></path></svg
                                        >
                                    </li>
                                {/if}
                            {/each}
                        </ol>
                    </nav>
                </div>
            </div>
        {/if}
    </div>

    <main
        class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl"
    >
        {@render children()}
    </main>
</div>
