<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ _env('APP_NAME', 'My Leaf MVC App') }}</title>
    <link rel="shortcut icon" href="https://leafphp.dev/logo-circle.png" type="image/x-icon">

    @vite('css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap"
        rel="stylesheet">

    @alpine
</head>

<body>
    <main
        class="min-h-screen flex flex-col items-center justify-start p-4 relative text-primary overflow-x-hidden bg-gradient-to-br from-background to-purple-200 dark:to-[#1A1A2E]">
        @include('components.welcome.topnav')
        @include('components.waitlist.form')

        <div class="relative z-10 max-w-6xl w-full mx-auto text-center pt-32 pb-24">
            <div class="mb-16">
                <div class="inline-flex items-center justify-center space-x-3">
                    <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z"
                            fill="#6366F1" />
                        <path d="M28 14L18 24L12 18" stroke="white" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-primary to-primary/70 bg-clip-text text-transparent">
                        My App
                    </span>
                </div>
            </div>

            <div class="space-y-8 mb-16 max-w-5xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold tracking-tight">
                    Get ready to do this & that
                    <span class="block mt-2">with My App</span>
                </h1>
                <p class="text-lg md:text-xl text-primary/70 max-w-2xl mx-auto leading-relaxed">
                    Say goodbye to doing this & that with greedy
                    expenses, My App is here to help you save money and
                    time, while making your life easier.
                </p>
            </div>

            <div class="mt-16 mb-12">
                <div
                    class="relative rounded-2xl shadow-lg border border-white/10 flex flex-col overflow-hidden bg-[#0B0B1A] w-full max-w-6xl mx-auto">
                    <div class="w-full px-4 py-3 border-b border-white/10 flex items-center gap-2">
                        <div class="w-3 h-3 bg-white/10 rounded-full"></div>
                        <div class="w-3 h-3 bg-white/10 rounded-full"></div>
                        <div class="w-3 h-3 bg-white/10 rounded-full"></div>
                    </div>

                    <div class="p-1">
                        <div class="w-full aspect-video rounded-lg overflow-hidden gradient-border bg-black/20">
                            <div class="w-full h-full flex items-center justify-center text-white/20 text-sm">
                                Preview coming soon
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-center space-x-6 pb-8">
                <a href="#" class="text-gray-500 hover:text-gray-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </main>
</body>

</html>
