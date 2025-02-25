import { cn } from "@/utils";

export default function InputError({ message, className = "", ...props }) {
    return message ? (
        <p
            className={cn("text-sm text-red-600 dark:text-red-400", className)}
            {...props}
        >
            {message}
        </p>
    ) : null;
}
