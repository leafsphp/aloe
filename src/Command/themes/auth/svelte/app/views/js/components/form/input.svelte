<script>
    import { cn } from "@/utils";

    const { class: className, type = "text", ...props } = $props();
</script>

<input
    type={type}
    class={cn(
        "flex h-10 w-full rounded-lg border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm",
        className,
    )}
    {...props}
/>
