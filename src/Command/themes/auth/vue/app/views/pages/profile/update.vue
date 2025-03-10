<script setup>
import Layout from '@/layouts/app-layout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/shared/heading-small.vue';
import { TransitionRoot } from '@headlessui/vue';
import { Button } from '@/components/form/button';
import { Input, InputError, Label } from '@/components/form/input';

const page = usePage();
const user = page.props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch('/settings/profile', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Profile Settings" />

    <Layout variant="sidebar" :breadcrumbs="[
        {
            title: 'Profile settings',
            href: '/settings/profile',
        },
    ]">
        <div class="space-y-6 px-4 py-4">
            <HeadingSmall title="Profile information" description="Update your name and email address" />

            <form @submit.prevent="submit" class="space-y-6 max-w-xl">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name"
                        placeholder="Full name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                        autocomplete="username" placeholder="Email address" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">Save</Button>

                    <TransitionRoot :show="form.recentlySuccessful" enter="transition ease-in-out"
                        enter-from="opacity-0" leave="transition ease-in-out" leave-to="opacity-0">
                        <p class="text-sm text-neutral-600">Saved.</p>
                    </TransitionRoot>
                </div>
            </form>
        </div>
    </Layout>
</template>
