import { cn } from "@/utils";

export function Icon({ name: IconComponent, className, ...props }) {
    return <IconComponent className={cn("h-4 w-4", className)} {...props} />;
}
