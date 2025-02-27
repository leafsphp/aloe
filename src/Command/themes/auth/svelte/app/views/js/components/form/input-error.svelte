<script>
    import { cn } from "@/utils";

    const { class: className, message, ...props } = $props();
</script>

<p
    class={cn("text-sm text-red-600 dark:text-red-400", className)}
    {...props}
>
    {message}
</p>
