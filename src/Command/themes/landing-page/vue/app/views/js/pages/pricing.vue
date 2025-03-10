<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { Check } from 'lucide-vue-next';

import Navbar from '@/components/layout/navbar.vue';
import { Button } from '@/components/form/button';

defineProps({
    auth: Object,
});
</script>

<template>

    <Head title="Pricing" />

    <Navbar :auth="auth" />

    <section class="mt-36 mb-16 flex items-center px-6">
        <div class="mx-auto grid w-full container gap-y-8 lg:grid-cols-2">
            <div class="max-w-xl space-y-8">
                <h1 class="text-4xl !leading-[1.2] text-strong sm:text-5xl">
                    Start doing this and that fast
                </h1>

                <p class="max-w-lg text-base leading-normal sm:text-xl">
                    Do this and that with minal effort and maximum
                    results. Start for free, upgrade only when you're
                    ready, and do more with powerful tools from my-app
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="px-6 lg:pb-16">
            <div class="mx-auto w-full max-w-xl lg:container">
                <div
                    class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-x-px lg:gap-y-0 lg:border-b lg:border-t lg:border-chart-2/20 lg:bg-chart-2/20">
                    <div
                        class="grid grid-cols-1 grid-rows-[auto,1fr] gap-px divide-y divide-chart-2/20 rounded-xl border border-chart-2/20 lg:divide-none lg:rounded-none lg:border-0 lg:bg-chart-3/20">
                        <div class="p-5 lg:bg-default xl:p-8 lg:!pb-0">
                            <h3 class="text-3xl font-normal tracking-tight text-strong xl:text-[32px]">
                                Starter
                            </h3>
                            <p class="mt-2 font-medium">
                                <span class="text-semibold text-xl">
                                    $0/month
                                </span>
                                <br />
                                <small class="dark:text-chart-2">
                                    +extra fees or not
                                </small>
                            </p>
                        </div>
                        <div class="flex flex-col items-stretch p-5 lg:bg-default xl:p-8">
                            <p class="font-medium text-strong">
                                Everything you need to do this and that
                            </p>
                            <ul class="mt-4 flex-1 space-y-2.5">
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                            </ul>

                            <Button :as="Link" class="relative isolate mt-6" href="/auth/register">
                                {{ auth.user
                                    ? "Go to dashboard"
                                    : "Do this and that for free" }}
                            </Button>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-1 grid-rows-[auto,1fr] gap-px divide-y divide-chart-2/20 rounded-xl border border-chart-2/20 lg:divide-none lg:rounded-none lg:border-0 lg:bg-chart-2/20">
                        <div class="p-5 lg:bg-default xl:p-8 lg:!pb-0">
                            <h3 class="text-3xl font-normal tracking-tight text-strong xl:text-[32px]">
                                Pro
                            </h3>
                            <p class="mt-2 font-medium">
                                <span class="text-semibold text-xl">
                                    $20/month
                                </span>
                                <br />
                                <small class="dark:text-chart-2">
                                    +extra fees or not
                                </small>
                            </p>
                        </div>
                        <div class="flex flex-col items-stretch p-5 lg:bg-default xl:p-8">
                            <p class="font-medium text-strong">
                                Do this and that with better precision
                            </p>
                            <ul class="mt-4 flex-1 space-y-2.5">
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Everything in Free</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                                <li class="flex items-center gap-2 text-sm font-medium">
                                    <Check class="size-4" />
                                    <span>Feature</span>
                                </li>
                            </ul>

                            <Button disabled class="relative isolate mt-6">
                                Coming soon
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="mx-auto max-w-2xl py-20 text-xl font-medium">
                    <blockquote class="relative">
                        <span class="absolute -left-2 top-0">
                            “
                        </span>
                        <p>
                            <i class="font-light">
                                Doing this and that was super difficult
                                until I found my-app. Now I can do this
                                and that with ease and precision. I
                                recommend my-app to everyone who wants to
                                do this and that
                            </i>
                            ”
                        </p>

                        <div class="mt-6 flex items-center gap-3 text-base">
                            <div class="size-12 overflow-hidden rounded shadow-inner">
                                <img src="#" alt="my-app user" class="size-full" />
                            </div>

                            <div>
                                <p class="text-strong">
                                    my-app user"
                                </p>
                                <p class="text-default">
                                    CEO at Company X
                                </p>
                            </div>
                        </div>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
</template>
