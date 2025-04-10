import { useForm, usePage } from "@inertiajs/react";

import Input from "@/components/form/input";
import Button from "@/components/form/button";

const WaitlistForm = () => {
    const auth = usePage().props.auth;
    const { data, setData, post, processing, reset, recentlySuccessful } =
        useForm({
            email: "",
        });

    const submit = (e) => {
        e.preventDefault();

        post("/waitlist", {
            onFinish: () => reset("email"),
        });
    };

    if (auth.user) {
        return null;
    }

    return (
        <div className="fixed left-1/2 -translate-x-1/2 bottom-8 z-50">
            <div className="bg-background backdrop-blur-md rounded-xl border-4 dark:border-white/[0.015] py-2 px-2 shadow-[0_8px_32px_-4px_rgba(0,0,0,0.3)] animate-float hover:animate-none">
                <div className="w-full flex flex-col sm:flex-row items-center gap-3">
                    {!recentlySuccessful ? (
                        <form
                            className="w-full flex flex-col sm:flex-row items-center gap-3"
                            onSubmit={submit}
                        >
                            <Input
                                id="email"
                                type="email"
                                className="block w-full sm:w-80 border-0 outline-0 focus-visible:ring-0 focus-visible:ring-offset-0 text-primary"
                                value={data.email}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                required
                                autoComplete="username"
                                placeholder="Email address"
                            />

                            <Button loading={processing} disabled={processing}>
                                Join Waitlist
                            </Button>
                        </form>
                    ) : (
                        <div className="h-9 px-4 flex items-center">
                            <p className="text-sm text-primary inline-flex items-center gap-2">
                                <svg
                                    className="w-4 h-4"
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
                    )}

                    {/* <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <div className="h-9 px-4 flex items-center">
                            <p className="text-white/90 text-sm inline-flex items-center gap-2">
                                <svg
                                    className="w-4 h-4 text-[#7C3AED]"
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
                    </Transition> */}
                </div>
            </div>
        </div>
    );
};

export default WaitlistForm;
