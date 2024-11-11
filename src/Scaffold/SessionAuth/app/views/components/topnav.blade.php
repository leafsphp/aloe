<header data-zero-component="Navbar" class="relative z-50 w-full flex-none text-sm font-semibold px-3">
    <nav
        class="mx-auto max-w-[85rem] px-4 sm:px-0 data-zero-Navbar-nav flex items-center py-4 border-b border-b-slate-900/5">
        <a href="/" class="flex-none flex items-center">
            <span class="sr-only">{{ _env('APP_NAME') }}</span>
            <img src="https://leafphp.dev/logo-circle.png" alt="{{ _env('APP_NAME') }}" class="h-8 w-auto">
            <span class="ml-3 text-lg">{{ _env('APP_NAME') }}</span>
        </a>

        <div class="ml-auto hidden lg:flex lg:items-center gap-8">
            @if (auth()->user())
                <a href="/dashboard"
                    class="font-normal focus:outline-none focus:text-gray-800 transition duration-150 ease-in-out">
                    Dashboard
                </a>
                <a href="/dashboard/user"
                    class="font-normal focus:outline-none focus:text-gray-800 transition duration-150 ease-in-out">
                    Profile
                </a>
            @else
                <a href="#">Some link</a>
            @endif

            <button type="button" class="-my-1 -mr-1 flex h-8 w-8 items-center justify-center lg:hidden ml-auto">
                <span class="sr-only">Open navigation</span>
                <svg viewBox="0 0 24 24" class="h-6 w-6 stroke-slate-900">
                    <path d="M3.75 12h16.5M3.75 6.75h16.5M3.75 17.25h16.5" fill="none" stroke-width="1.5"
                        stroke-linecap="round"></path>
                </svg>
            </button>
        </div>

        @if (!auth()->user())
            <div class="hidden lg:ml-8 lg:flex lg:items-center lg:border-l lg:border-slate-400/15 lg:pl-8">
                <a href="/auth/login" variant="text" data-zero-component="Button"
                    class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-2">
                    Sign in
                </a>
                <a href="/auth/register"
                    class="transition-all inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 bg-green-600 hover:bg-green-500 text-white ml-8"
                    data-zero-component="Button">
                    Sign up
                </a>
            </div>
        @else
            <div class="hidden md:flex md:items-center sm:ml-6">
                <div x-data="{
                    open: false,
                    toggle() {
                        if (this.open) {
                            return this.close()
                        }

                        this.$refs.button.focus()

                        this.open = true
                    },
                    close(focusAfter) {
                        if (!this.open) return

                        this.open = false

                        focusAfter && focusAfter.focus()
                    }
                }" x-on:keydown.escape.prevent.stop="close($refs.button)"
                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']"
                    class="relative inline-block text-left">
                    <button type="button" x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-50"
                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                        {{ auth()->user()->name }}
                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!--
                        Dropdown menu, show/hide based on menu state.

                        Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
                    <div x-ref="panel" x-show="open" x-transition.origin.top.left
                            x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->
                            <a href="/dashboard/user" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="menu-item-0">Account settings</a>
                            <form method="POST" action="/auth/logout" role="none">
                                {{ csrf()->form() }}
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700"
                                    role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </nav>
</header>
