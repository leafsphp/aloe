<div class="fixed left-1/2 -translate-x-1/2 bottom-8 z-50">
    <div
        class="bg-background backdrop-blur-md rounded-xl border-4 dark:border-white/[0.015] py-2 px-2 shadow-[0_8px_32px_-4px_rgba(0,0,0,0.3)] animate-float hover:animate-none">
        <div class="w-full flex flex-col sm:flex-row items-center gap-3">
            @flash('waitlist.success')
                <div class="h-9 px-4 flex items-center">
                    <p class="text-sm text-primary inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Thanks for joining!
                    </p>
                </div>
            @else
                <form class="w-full flex flex-col sm:flex-row items-center gap-3" action="/waitlist" method="POST">
                    @csrf
                    <input type="email" id="email" name="email" placeholder="Email Address"
                        class="block w-full sm:w-80 border-0 outline-0 focus-visible:ring-0 focus-visible:ring-offset-0 text-primary px-4"
                        required autocomplete="username" placeholder="Email address" :disabled="loading">

                    <button type="submit"
                        class="w-full sm:w-auto px-6 h-12 bg-primary text-white rounded-lg font-medium hover:opacity-90 transition-all duration-200 focus:outline-none text-sm relative whitespace-nowrap min-w-[120px] flex items-center justify-center"
                        :disabled="loading">
                        Join Waitlist
                    </button>
                </form>
            @endflash
        </div>
    </div>
</div>
