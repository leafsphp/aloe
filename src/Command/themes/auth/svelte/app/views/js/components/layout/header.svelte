<script>
    import { page } from "@inertiajs/svelte";
    import { getInitials } from "@/utils";
    import UserMenuContent from "./user-menu-content.svelte";

    const { user } = $page.props.auth;

    function clickOutside(node) {
        window.addEventListener("click", handleClick);

        function handleClick(e) {
            if (!node.contains(e.target)) {
                node.dispatchEvent(new CustomEvent("outsideclick"));
            }
        }

        return {
            destroy() {
                window.removeEventListener("click", handleClick);
            },
        };
    }

    let isUserMenuToggled = $state(false);
</script>

<div class="border-b border-sidebar-border/80">
    <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
        <!-- Mobile Menu -->
        <div class="lg:hidden">
            <button
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground mr-2 h-9 w-9"
                type="button"
                aria-haspopup="dialog"
                aria-expanded="false"
                data-state="closed"
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-menu-icon h-5 w-5"
                    ><line x1="4" x2="20" y1="12" y2="12"></line><line
                        x1="4"
                        x2="20"
                        y1="6"
                        y2="6"
                    ></line><line x1="4" x2="20" y1="18" y2="18"></line></svg
                ></button
            >
        </div>
        <a
            class="flex items-center gap-x-2"
            href="/dashboard"
        >
            LOGO
        </a>
        <!-- Desktop Menu -->
        <div class="hidden h-full lg:flex lg:flex-1">
            <nav
                aria-label="Main"
                data-orientation="horizontal"
                dir="ltr"
                data-radix-navigation-menu=""
                class="relative z-10 max-w-max flex-1 justify-center ml-10 flex h-full items-stretch"
            >
                <div style="position: relative;">
                    <ul
                        class="group flex-1 list-none justify-center gap-x-1 flex h-full items-stretch space-x-2"
                        data-orientation="horizontal"
                    >
                        <li
                            data-menu-item=""
                            class="relative flex h-full items-center"
                        >
                            <a
                                href="/dashboard"
                                data-radix-vue-collection-item=""
                                class="group inline-flex h-10 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 data-[active]:bg-accent/50 data-[state=open]:bg-accent/50 text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100 h-9 cursor-pointer px-3"
                                ><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-layout-grid-icon mr-2 h-4 w-4"
                                    ><rect
                                        width="7"
                                        height="7"
                                        x="3"
                                        y="3"
                                        rx="1"
                                    ></rect><rect
                                        width="7"
                                        height="7"
                                        x="14"
                                        y="3"
                                        rx="1"
                                    ></rect><rect
                                        width="7"
                                        height="7"
                                        x="14"
                                        y="14"
                                        rx="1"
                                    ></rect><rect
                                        width="7"
                                        height="7"
                                        x="3"
                                        y="14"
                                        rx="1"
                                    ></rect></svg
                                > Dashboard</a
                            >
                            <div
                                class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                            ></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="ml-auto flex items-center space-x-2">
            <div class="relative flex items-center space-x-1">
                <button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground group h-9 w-9 cursor-pointer"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-search-icon size-5 opacity-80 group-hover:opacity-100"
                        ><circle cx="11" cy="11" r="8"></circle><path
                            d="m21 21-4.3-4.3"
                        ></path></svg
                    ></button
                >
            </div>
            <button
                class="inline-flex relative items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground outline-none relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                id="radix-vue-dropdown-menu-trigger-v-5"
                type="button"
                use:clickOutside
                onoutsideclick={() => (isUserMenuToggled = false)}
                aria-haspopup="menu"
                aria-expanded={isUserMenuToggled}
                data-state={isUserMenuToggled ? "open" : "closed"}
                onclick={() => (isUserMenuToggled = !isUserMenuToggled)}
            >
                <span
                    class="inline-flex items-center justify-center font-normal text-foreground select-none shrink-0 bg-secondary text-xs size-8 overflow-hidden rounded-full"
                >
                    {#if user.avatar}
                        <img
                            src={user.avatar}
                            alt="User avatar"
                            class="rounded-full w-8 h-8"
                        />
                    {:else}
                        <span
                            class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                            >{getInitials(user.name)}</span
                        >
                    {/if}
                </span>

                <UserMenuContent
                    show={isUserMenuToggled}
                    showEmail={true}
                    {user}
                />
            </button>
        </div>
    </div>
</div>
