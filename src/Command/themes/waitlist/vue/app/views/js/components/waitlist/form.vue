<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

import { Button } from '@/components/form/button';
import { Input } from '@/components/form/input';

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/waitlist', {
        onFinish: () => reset('email'),
    });
};
</script>

<template>
    <div class="fixed left-1/2 -translate-x-1/2 bottom-8 z-50" v-if="!user">
        <div
            class="bg-background backdrop-blur-md rounded-xl border-4 dark:border-white/[0.015] py-2 px-2 shadow-[0_8px_32px_-4px_rgba(0,0,0,0.3)] animate-float hover:animate-none">
            <div class="w-full flex flex-col sm:flex-row items-center gap-3">
                <form v-if="!form.recentlySuccessful" class="w-full flex flex-col sm:flex-row items-center gap-3" @submit.prevent="submit">
                    <Input id="email" type="email"
                        class="block w-full sm:w-80 border-0 outline-0 focus-visible:ring-0 focus-visible:ring-offset-0 text-primary"
                        v-model="form.email" required autocomplete="username" placeholder="Email address" />

                    <Button :loading="form.processing" :disabled="form.processing">
                        Join Waitlist
                    </Button>
                </form>
                <div v-else class="h-9 px-4 flex items-center">
                    <p class="text-sm text-primary inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Thanks for joining!
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
