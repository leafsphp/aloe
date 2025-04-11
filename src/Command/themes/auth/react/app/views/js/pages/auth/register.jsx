import { Head, Link, useForm } from "@inertiajs/react";

import Input from "@/components/form/input";
import InputError from "@/components/form/input-error";
import Button from "@/components/form/button";
// import Label from "@/components/form/label";

export default function Register({ request }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: request?.email || "",
        password: "",
        confirmPassword: "",
        invite: request?.invite || "",
    });

    const submit = (e) => {
        e.preventDefault();

        post("/auth/register", {
            onFinish: () => reset("password", "confirmPassword"),
        });
    };

    return (
        <div className="bg-background flex relative z-30 flex-col justify-center w-screen min-h-screen items-stretch sm:items-center sm:py-10">
            <Head title="Sign up" />

            <div className="flex relative top-0 z-20 flex-col justify-center items-stretch px-10 py-8 w-full h-screen bg-white border-gray-200 sm:top-auto sm:h-full sm:border sm:rounded-xl sm:max-w-md text-black">
                <div className="flex flex-col sm:mx-auto sm:w-full mb-5 sm:max-w-md items-center text-black">
                    <Link href="/">
                        <img
                            src="https://leafphp.dev/logo-circle.png"
                            alt="Leaf MVC"
                            className="size-10"
                        />
                    </Link>
                    <h1 className="mt-5 mb-1 text-2xl lg:text-3xl font-semibold">
                        Hello there
                    </h1>
                    <h2 className="text-sm">Create your account</h2>
                </div>

                <form onSubmit={submit}  class="space-y-4 w-full">
                    <div>
                        <Input
                            id="name"
                            type="name"
                            name="name"
                            placeholder="Name"
                            value={data.name}
                            className="mt-1 block w-full bg-white border-gray-300 rounded-md focus:border-indigo-300"
                            autoComplete="name"
                            isFocused={true}
                            onChange={(e) => setData("name", e.target.value)}
                        />

                        <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="Email"
                            value={data.email}
                            className="mt-1 block w-full bg-white border-gray-300 rounded-md focus:border-indigo-300"
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => setData("email", e.target.value)}
                        />

                        <InputError
                            message={errors.email || errors?.auth}
                            className="mt-2"
                        />
                    </div>

                    <div>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Password"
                            value={data.password}
                            className="mt-1 block w-full bg-white border-gray-300 rounded-md focus:border-indigo-300"
                            autoComplete="current-password"
                            onChange={(e) =>
                                setData("password", e.target.value)
                            }
                        />

                        <InputError
                            message={errors?.password}
                            className="mt-2"
                        />
                    </div>

                    <div>
                        <Input
                            id="confirmPassword"
                            type="password"
                            name="confirmPassword"
                            placeholder="Confirm Password"
                            value={data.confirmPassword}
                            className="mt-1 block w-full bg-white border-gray-300 rounded-md focus:border-indigo-300"
                            autoComplete="current-password"
                            onChange={(e) =>
                                setData("confirmPassword", e.target.value)
                            }
                        />

                        <InputError
                            message={errors?.confirmPassword}
                            className="mt-2"
                        />
                    </div>

                    <Button
                        className="w-full bg-primary hover:bg-primary-light text-white"
                        disabled={processing}
                    >
                        Sign Up
                    </Button>
                </form>

                <div className="mt-3 space-x-0.5 text-sm leading-5 text-left text-gray-950">
                    <span className="opacity-[60%]">
                        Already have an account?
                    </span>
                    <Link
                        className="underline cursor-pointer opacity-[75%] hover:opacity-[85%]"
                        href="/auth/login"
                    >
                        Sign In
                    </Link>
                </div>

                <div className="flex justify-center items-center w-full text-zinc-400 uppercase text-xs my-6">
                    <span className="w-full h-px bg-zinc-300"></span>
                    <span className="px-2 w-auto">or</span>
                    <span className="w-full h-px bg-zinc-300"></span>
                </div>

                <div className="relative space-y-2 w-full">
                    <Button
                        as={Link}
                        href="/auth/google"
                        className="py-3 space-x-2.5 gap-0 w-full h-auto text-sm justify-start border border-zinc-200 text-zinc-600 hover:bg-zinc-100 bg-white"
                    >
                        <span className="w-5 h-5">
                            <svg
                                className="w-full h-full"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48"
                                fill="none"
                            >
                                <path
                                    fill="#4285F4"
                                    d="M24 19.636v9.295h12.916c-.567 2.989-2.27 5.52-4.822 7.222l7.79 6.043c4.537-4.188 7.155-10.341 7.155-17.65 0-1.702-.152-3.339-.436-4.91H24Z"
                                ></path>
                                <path
                                    fill="#34A853"
                                    d="m10.55 28.568-1.757 1.345-6.219 4.843C6.524 42.59 14.617 48 24 48c6.48 0 11.913-2.138 15.884-5.804l-7.79-6.043c-2.138 1.44-4.865 2.313-8.094 2.313-6.24 0-11.541-4.211-13.44-9.884l-.01-.014Z"
                                ></path>
                                <path
                                    fill="#FBBC05"
                                    d="M2.574 13.244A23.704 23.704 0 0 0 0 24c0 3.883.938 7.527 2.574 10.756 0 .022 7.986-6.196 7.986-6.196A14.384 14.384 0 0 1 9.796 24c0-1.593.284-3.12.764-4.56l-7.986-6.196Z"
                                ></path>
                                <path
                                    fill="#EA4335"
                                    d="M24 9.556c3.534 0 6.676 1.222 9.185 3.579l6.873-6.873C35.89 2.378 30.48 0 24 0 14.618 0 6.523 5.39 2.574 13.244l7.986 6.196c1.898-5.673 7.2-9.884 13.44-9.884Z"
                                ></path>
                            </svg>
                        </span>
                        <span>Continue with Google</span>
                    </Button>

                    <Button
                        as={Link}
                        href="/auth/github"
                        className="py-3 space-x-2.5 gap-0 w-full h-auto text-sm justify-start border border-zinc-200 text-zinc-600 hover:bg-zinc-100 bg-white"
                    >
                        <span className="w-5 h-5">
                            <svg
                                className="w-full h-full"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48"
                                fill="none"
                            >
                                <path
                                    fill="#24292F"
                                    fillRule="evenodd"
                                    d="M24.02 0C10.738 0 0 10.817 0 24.198 0 34.895 6.88 43.95 16.424 47.154c1.193.241 1.63-.52 1.63-1.161 0-.561-.039-2.484-.039-4.488-6.682 1.443-8.073-2.884-8.073-2.884-1.074-2.805-2.665-3.525-2.665-3.525-2.187-1.483.16-1.483.16-1.483 2.425.16 3.698 2.484 3.698 2.484 2.147 3.686 5.607 2.644 7 2.003.198-1.562.834-2.644 1.51-3.245-5.329-.56-10.936-2.644-10.936-11.939 0-2.644.954-4.807 2.466-6.49-.239-.6-1.074-3.085.239-6.41 0 0 2.028-.641 6.6 2.484 1.959-.53 3.978-.8 6.006-.802 2.028 0 4.095.281 6.005.802 4.573-3.125 6.601-2.484 6.601-2.484 1.313 3.325.477 5.81.239 6.41 1.55 1.683 2.465 3.846 2.465 6.49 0 9.295-5.607 11.338-10.976 11.94.876.76 1.63 2.202 1.63 4.486 0 3.245-.039 5.85-.039 6.65 0 .642.438 1.403 1.63 1.163C41.12 43.949 48 34.895 48 24.198 48.04 10.817 37.262 0 24.02 0Z"
                                    clipRule="evenodd"
                                ></path>
                            </svg>
                        </span>
                        <span>Continue with Github</span>
                    </Button>
                </div>
            </div>
        </div>
    );
}
