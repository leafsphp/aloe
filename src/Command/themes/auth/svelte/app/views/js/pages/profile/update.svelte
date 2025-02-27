<script>
    import { page, useForm } from "@inertiajs/svelte";

    import Layout from "@/layouts/app-layout.svelte";
    import Label from "@/components/form/label.svelte";
    import Input from "@/components/form/input.svelte";
    import Button from "@/components/form/button.svelte";
    import InputError from "@/components/form/input-error.svelte";
    import HeadingSmall from "@/components/shared/heading-small.svelte";

    const user = $page.props.auth.user;

    const form = useForm({
        name: user.name,
        email: user.email,
    });

    const submit = (e) => {
        e.preventDefault();

        $form.patch("/settings/profile", {
            preserveScroll: true,
        });
    };
</script>

<svelte:head>
    <title>Profile Settings</title>
</svelte:head>

<Layout
    breadcrumbs={[
        {
            title: "Profile settings",
            href: "/settings/profile",
        },
    ]}
>
    <div class="space-y-6 px-4 py-4">
        <HeadingSmall
            title="Profile information"
            description="Update your name and email address"
        />

        <form onsubmit={submit} class="space-y-6 max-w-xl">
            <div class="grid gap-2">
                <Label for="name">Name</Label>

                <Input
                    id="name"
                    class="mt-1 block w-full"
                    value={$form.name}
                    onchange={(e) => $form.name = e.target.value}
                    required
                    autoComplete="name"
                    placeholder="Full name"
                />

                <InputError class="mt-2" message={$form.errors.name} />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>

                <Input
                    id="email"
                    type="email"
                    className="mt-1 block w-full"
                    value={$form.email}
                    onChange={(e) => $form.email = e.target.value}
                    required
                    autoComplete="username"
                    placeholder="Email address"
                />

                <InputError class="mt-2" message={$form.errors.email} />
            </div>

            <div class="flex items-center gap-4">
                <Button disabled={$form.processing}>Save</Button>
            </div>
        </form>
    </div>
</Layout>
