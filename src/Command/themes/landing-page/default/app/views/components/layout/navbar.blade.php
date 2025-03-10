@php
    $logo = $logo ?? [
        'url' => '/',
        'src' => '#',
        'alt' => 'logo',
        'title' => 'LOGO',
    ];
    $menu = $menu ?? [
        [
            'title' => 'Pricing',
            'url' => '/pricing',
        ],
        [
            'title' => 'FAQs',
            'url' => '#',
        ],
    ];
@endphp

<header
    class="py-4 fixed top-0 left-0 w-full bg-background shadow-xs dark:shadow-primary-orange/20 z-50 backdrop-blur-2xl backdrop-opacity-20 flex justify-center items-center">
    <div class="container">
        <!-- Desktop Menu -->
        <nav class="hidden justify-between lg:flex">
            <div class="flex items-center gap-6">
                <a href="{{ $logo['url'] }}" class="flex items-center gap-2">
                    <img src="{{ $logo['src'] }}" class="size-5" alt="{{ $logo['alt'] }}" />
                    <span class="text-lg font-semibold">
                        {{ $logo['title'] }}
                    </span>
                </a>
                <div class="flex items-center">
                    <nav aria-label="Main" data-orientation="horizontal" dir="ltr"
                        class="relative z-10 flex max-w-max flex-1 items-center justify-center">
                        <div style="position: relative;">
                            <ul data-orientation="horizontal"
                                class="group flex flex-1 list-none items-center justify-center space-x-1"
                                dir="ltr">
                                @foreach ($menu as $item)
                                    <a class="group inline-flex h-10 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-accent-foreground"
                                        href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                                @endforeach
                            </ul>
                        </div>
                        <div class="absolute left-0 top-full flex justify-center"></div>
                    </nav>
                </div>
            </div>
            <div class="flex gap-2">
                @auth
                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-lg px-3"><a
                            href="/dashboard">Dashboard</a></button>
                @else
                    <Button asChild variant="outline" size="sm">
                        <Link href="/auth/login">Login</Link>
                    </Button>
                    <Button asChild size="sm" class="bg-primary-red hover:bg-primary-red/80 text-white">
                        <Link href="/auth/register">Sign up</Link>
                    </Button>
                @endauth
            </div>
        </nav>
        <!-- Mobile Menu: cutomize to your liking -->
        <div class="block lg:hidden">
            <div class="flex items-center justify-between">
                <a href="{{ $logo['url'] }}" class="flex items-center gap-2">
                    <img src="{{ $logo['src'] }}" class="size-5" alt="{{ $logo['alt'] }}" />
                    <span class="text-lg font-semibold">
                        {{ $logo['title'] }}
                    </span>
                </a>
                <button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10"
                    type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:r1:"
                    data-state="closed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-menu size-4">
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
