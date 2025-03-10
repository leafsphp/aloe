import { Link, Head } from "@inertiajs/react";
import { Check } from "lucide-react";
import Navbar from "@/components/layout/navbar";
import Button from "@/components/form/button";

const Pricing = ({ auth }) => {
    return (
        <>
            <Head title="Pricing" />

            <Navbar auth={auth} />

            <section className="mt-36 mb-16 flex items-center px-6">
                <div className="mx-auto grid w-full container gap-y-8 lg:grid-cols-2">
                    <div className="max-w-xl space-y-8">
                        <h1 className="text-4xl !leading-[1.2] text-strong sm:text-5xl">
                            Start doing this and that fast
                        </h1>

                        <p className="max-w-lg text-base leading-normal sm:text-xl">
                            Do this and that with minal effort and maximum
                            results. Start for free, upgrade only when you're
                            ready, and do more with powerful tools from my-app
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <div className="px-6 lg:pb-16">
                    <div className="mx-auto w-full max-w-xl lg:container">
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-x-px lg:gap-y-0 lg:border-b lg:border-t lg:border-chart-2/20 lg:bg-chart-2/20">
                            <div className="grid grid-cols-1 grid-rows-[auto,1fr] gap-px divide-y divide-chart-2/20 rounded-xl border border-chart-2/20 lg:divide-none lg:rounded-none lg:border-0 lg:bg-chart-3/20">
                                <div className="p-5 lg:bg-default xl:p-8 lg:!pb-0">
                                    <h3 className="text-3xl font-normal tracking-tight text-strong xl:text-[32px]">
                                        Starter
                                    </h3>
                                    <p className="mt-2 font-medium">
                                        <span className="text-semibold text-xl">
                                            $0/month
                                        </span>
                                        <br />
                                        <small className="dark:text-chart-2">
                                            +extra fees or not
                                        </small>
                                    </p>
                                </div>
                                <div className="flex flex-col items-stretch p-5 lg:bg-default xl:p-8">
                                    <p className="font-medium text-strong">
                                        Everything you need to do this and that
                                    </p>
                                    <ul className="mt-4 flex-1 space-y-2.5">
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                    </ul>

                                    <Button
                                        as={Link}
                                        className="relative isolate mt-6"
                                        href="/auth/register"
                                    >
                                        {auth.user
                                            ? "Go to dashboard"
                                            : "Do this and that for free"}
                                    </Button>
                                </div>
                            </div>
                            <div className="grid grid-cols-1 grid-rows-[auto,1fr] gap-px divide-y divide-chart-2/20 rounded-xl border border-chart-2/20 lg:divide-none lg:rounded-none lg:border-0 lg:bg-chart-2/20">
                                <div className="p-5 lg:bg-default xl:p-8 lg:!pb-0">
                                    <h3 className="text-3xl font-normal tracking-tight text-strong xl:text-[32px]">
                                        Pro
                                    </h3>
                                    <p className="mt-2 font-medium">
                                        <span className="text-semibold text-xl">
                                            $20/month
                                        </span>
                                        <br />
                                        <small className="dark:text-chart-2">
                                            +extra fees or not
                                        </small>
                                    </p>
                                </div>
                                <div className="flex flex-col items-stretch p-5 lg:bg-default xl:p-8">
                                    <p className="font-medium text-strong">
                                        Do this and that with better precision
                                    </p>
                                    <ul className="mt-4 flex-1 space-y-2.5">
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Everything in Free</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                        <li className="flex items-center gap-2 text-sm font-medium">
                                            <Check className="size-4" />
                                            <span>Feature</span>
                                        </li>
                                    </ul>

                                    <Button
                                        disabled
                                        className="relative isolate mt-6"
                                    >
                                        Coming soon
                                    </Button>
                                </div>
                            </div>
                        </div>
                        <div className="mx-auto max-w-2xl py-20 text-xl font-medium">
                            <blockquote className="relative">
                                <span className="absolute -left-2 top-0">
                                    “
                                </span>
                                <p>
                                    <i className="font-light">
                                        Doing this and that was super difficult
                                        until I found my-app. Now I can do this
                                        and that with ease and precision. I
                                        recommend my-app to everyone who wants to
                                        do this and that
                                    </i>
                                    ”
                                </p>

                                <div className="mt-6 flex items-center gap-3 text-base">
                                    <div className="size-12 overflow-hidden rounded shadow-inner">
                                        <img
                                            src="#"
                                            alt="my-app user"
                                            className="size-full"
                                        />
                                    </div>

                                    <div>
                                        <p className="text-strong">
                                            my-app user"
                                        </p>
                                        <p className="text-default">
                                            CEO at Company X
                                        </p>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default Pricing;
