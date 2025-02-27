<script>
    import { getInitials } from "@/utils";
    import { Link } from "@inertiajs/svelte";

    const { user, showEmail, show } = $props();
</script>

{#if show}
    <div
        data-radix-popper-content-wrapper=""
        style="position: absolute; right: 0px; top: 50px; min-width: max-content; --radix-popper-transform-origin: 100% 0px; z-index: 50; will-change: transform; --radix-popper-available-width: 1123px; --radix-popper-available-height: 801px; --radix-popper-anchor-width: 40px; --radix-popper-anchor-height: 40px;"
    >
        <div
            role="menu"
            aria-orientation="vertical"
            data-radix-menu-content=""
            data-state="open"
            dir="ltr"
            tabindex="-1"
            data-orientation="vertical"
            data-dismissable-layer=""
            id="radix-vue-dropdown-menu-content-v-6"
            aria-labelledby="radix-vue-dropdown-menu-trigger-v-5"
            class="z-50 min-w-32 overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-md data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 w-56"
            data-side="bottom"
            data-align="end"
            style="outline: none; --radix-dropdown-menu-content-transform-origin: var(--radix-popper-transform-origin); --radix-dropdown-menu-content-available-width: var(--radix-popper-available-width); --radix-dropdown-menu-content-available-height: var(--radix-popper-available-height); --radix-dropdown-menu-trigger-width: var(--radix-popper-anchor-width); --radix-dropdown-menu-trigger-height: var(--radix-popper-anchor-height); pointer-events: auto;"
        >
            <div class="text-sm p-0 font-normal">
                <div
                    class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                >
                    <span
                        class="inline-flex items-center justify-center font-normal text-foreground select-none shrink-0 bg-secondary text-xs h-8 w-8 overflow-hidden rounded-lg"
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
                    <div class="grid flex-1 text-left text-sm leading-tight">
                        <span class="truncate font-medium">{user.name}</span>
                        {#if showEmail}
                            <span class="truncate text-xs text-muted-foreground"
                                >{user.email}</span
                            >
                        {/if}
                    </div>
                </div>
            </div>
            <div
                role="separator"
                aria-orientation="horizontal"
                class="-mx-1 my-1 h-px bg-muted"
            ></div>
            <div role="group">
                <Link
                    as="button"
                    href="/settings/profile"
                    role="menuitem"
                    tabindex="-1"
                    class="relative flex cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;>svg]:size-4 [&amp;>svg]:shrink-0 block w-full"
                    data-radix-vue-collection-item=""
                    type="button"
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
                        class="lucide lucide-settings-icon mr-2 h-4 w-4"
                        ><path
                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"
                        ></path><circle cx="12" cy="12" r="3"></circle></svg
                    > Settings
                </Link>
            </div>
            <div
                role="separator"
                aria-orientation="horizontal"
                class="-mx-1 my-1 h-px bg-muted"
            ></div>
            <Link
                as="button"
                href="/auth/logout"
                role="menuitem"
                tabindex="-1"
                class="relative flex cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;>svg]:size-4 [&amp;>svg]:shrink-0 block w-full"
                data-radix-vue-collection-item=""
                type="button"
                method="post"
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
                    class="lucide lucide-log-out-icon mr-2 h-4 w-4"
                    ><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                    ></path><polyline points="16 17 21 12 16 7"></polyline><line
                        x1="21"
                        x2="9"
                        y1="12"
                        y2="12"
                    ></line></svg
                > Log out
            </Link>
        </div>
    </div>
{/if}
