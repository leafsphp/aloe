import { usePage } from "@inertiajs/vue3";
import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function getInitials(fullName) {
    const names = fullName.trim().split(" ");

    if (names.length === 0) return "";
    if (names.length === 1) return names[0].charAt(0).toUpperCase();

    return `${names[0].charAt(0)}${names[names.length - 1].charAt(
        0,
    )}`.toUpperCase();
}

export function useAuth() {
    return usePage().props.auth;
}
