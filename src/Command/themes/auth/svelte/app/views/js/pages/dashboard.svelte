<script>
    import Layout from "@/layouts/app-layout.svelte";
</script>

<svelte:head>
  <title>Dashboard</title>
</svelte:head>

<Layout
    breadcrumbs={[
        {
            title: "Dashboard",
            href: "/dashboard",
        },
    ]}
>
    <div class="py-4 px-4">
        <div class="overflow-hidden shadow-sm sm:rounded-lg bg-black">
            <div class="p-6 text-gray-100">You're logged in!</div>
        </div>
    </div>
</Layout>
