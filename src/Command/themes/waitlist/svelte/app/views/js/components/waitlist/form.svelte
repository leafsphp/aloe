<script>
    import { page, useForm } from "@inertiajs/svelte";

    import Input from "@/components/form/input.svelte";
    import Button from "@/components/form/button.svelte";

    const user = $page.props.auth.user;

    const form = useForm({
        email: "",
    });

    const submit = (e) => {
        e.preventDefault();

        $form.post("/waitlist", {
            onFinish: () => $form.email = "",
        });
    };
</script>

{#if !user}
    <div class="fixed left-1/2 -translate-x-1/2 bottom-8 z-50">
        <div class="bg-background backdrop-blur-md rounded-xl border-4 dark:border-white/[0.015] py-2 px-2 shadow-[0_8px_32px_-4px_rgba(0,0,0,0.3)] animate-float hover:animate-none">
            <div class="w-full flex flex-col sm:flex-row items-center gap-3">
                {#if !$form.recentlySuccessful}
                    <form
                        class="w-full flex flex-col sm:flex-row items-center gap-3"
                        onsubmit={submit}
                    >
                        <Input
                            id="email"
                            type="email"
                            class="block w-full sm:w-80 border-0 outline-0 focus-visible:ring-0 focus-visible:ring-offset-0 text-primary"
                            value={$form.email}
                            onchange={(e) => $form.email = e.target.value}
                            required
                            autoComplete="username"
                            placeholder="Email address"
                        />

                        <Button loading={$form.processing} disabled={$form.processing}>
                            Join Waitlist
                        </Button>
                    </form>
                {:else}
                    <div class="h-9 px-4 flex items-center">
                        <p class="text-sm text-primary inline-flex items-center gap-2">
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                ></path>
                            </svg>
                            Thanks for joining!
                        </p>
                    </div>
                {/if}
            </div>
        </div>
    </div>
{/if}
