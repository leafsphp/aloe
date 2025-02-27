<script>
import { cn } from "@/utils";
import { cva } from "class-variance-authority";

const { class: className, children, ...props } = $props();

    const labelVariants = cva(
        "text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70",
    );
</script>

<label {...props} class={cn(labelVariants, className)}>
    {@render children()}
</label>
