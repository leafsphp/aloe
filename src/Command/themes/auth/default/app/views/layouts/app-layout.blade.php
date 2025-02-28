<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ _env('APP_NAME', 'Leaf MVC') }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">

    @vite('css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap"
        rel="stylesheet">

    @alpine
</head>

<body>
    <div x-data="{
        sidebar: {
            open: false,
            toggle() {
                this.open = !this.open;
            },
            open() {
                this.open = true;
            },
            close() {
                this.open = false;
            },
        },
    }"
        class="group/sidebar-wrapper flex min-h-svh w-full text-sidebar-foreground has-[[data-variant=inset]]:bg-sidebar"
        style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem;">
        @include('components.layout.header')

        <main
            class="relative flex min-h-svh flex-1 flex-col bg-background peer-data-[variant=inset]:min-h-[calc(100svh-theme(spacing.4))] md:peer-data-[variant=inset]:m-2 md:peer-data-[state=collapsed]:peer-data-[variant=inset]:ml-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow">
            <header
                class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12 md:px-4">
                <div class="flex items-center gap-2">
                    <button @click="sidebar.toggle()"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-7 w-7 -ml-1"
                        data-sidebar="trigger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-panel-left-icon">
                            <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                            <path d="M9 3v18"></path>
                        </svg>
                        <span class="sr-only">Toggle Sidebar</span>
                    </button>
                    <nav aria-label="breadcrumb" class="">
                        <ol
                            class="flex flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground sm:gap-2.5">
                            @foreach ($breadcrumbs as $breadcrumb)
                                @if ($loop->last)
                                    <li class="inline-flex items-center gap-1.5"><span role="link"
                                            aria-disabled="true" aria-current="page"
                                            class="font-normal text-foreground">Dashboard</span></li>
                                @else
                                    <li class="inline-flex items-center gap-1.5"><a
                                            class="transition-colors hover:text-foreground"><a
                                                href="/dashboard">Dashboard</a></a></li>
                                    <li role="presentation" aria-hidden="true"
                                        class="[&>svg]:h-3.5 [&>svg]:w-3.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-chevron-right-icon">
                                            <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    @toastContainer
</body>

</html>
