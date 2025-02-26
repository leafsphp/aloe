import Layout from "@/layouts/app-layout";
import { Head } from "@inertiajs/react";

export default function Dashboard() {
    return (
        <Layout
            variant="sidebar"
            breadcrumbs={[
                {
                    title: "Dashboard",
                    href: "/dashboard",
                },
            ]}
        >
            <Head title="Dashboard" />

            <div className="py-4 px-4">
                <div className="overflow-hidden shadow-sm sm:rounded-lg bg-black">
                    <div className="p-6 text-gray-100">You're logged in!</div>
                </div>
            </div>
        </Layout>
    );
}
