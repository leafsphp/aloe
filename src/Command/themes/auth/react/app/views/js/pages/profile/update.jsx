import { Head, useForm } from "@inertiajs/react";

import Layout from "@/layouts/app-layout";
import HeadingSmall from "@/components/shared/heading-small";
import InputError from "@/components/form/input-error";
import Button from "@/components/form/button";
import Input from "@/components/form/input";
import Label from "@/components/form/label";

export default function Profile({ auth }) {
    const { data, setData, patch, errors, processing } = useForm({
        name: auth.user.name,
        email: auth.user.email,
    });

    const submit = (e) => {
        e.preventDefault();

        patch("/settings/profile");
    };

    return (
        <Layout
            breadcrumbs={[
                {
                    title: "Profile settings",
                    href: "/settings/profile",
                },
            ]}
        >
            <Head title="Profile settings" />

            <div className="space-y-6 px-4 py-4">
                <HeadingSmall
                    title="Profile information"
                    description="Update your name and email address"
                />

                <form onSubmit={submit} className="space-y-6 max-w-xl">
                    <div className="grid gap-2">
                        <Label htmlFor="name">Name</Label>

                        <Input
                            id="name"
                            className="mt-1 block w-full"
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            required
                            autoComplete="name"
                            placeholder="Full name"
                        />

                        <InputError className="mt-2" message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="email">Email address</Label>

                        <Input
                            id="email"
                            type="email"
                            className="mt-1 block w-full"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            required
                            autoComplete="username"
                            placeholder="Email address"
                        />

                        <InputError className="mt-2" message={errors.email} />
                    </div>

                    <div className="flex items-center gap-4">
                        <Button disabled={processing}>Save</Button>

                        {/* <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm text-neutral-600">Saved</p>
                        </Transition> */}
                    </div>
                </form>
            </div>
        </Layout>
    );
}
