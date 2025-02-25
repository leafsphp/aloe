import { useEffect, useState } from "react";

const prefersDark = () =>
    window.matchMedia("(prefers-color-scheme: dark)").matches;

const applyTheme = (appearance) => {
    const isDark =
        appearance === "dark" || (appearance === "system" && prefersDark());

    document.documentElement.classList.toggle("dark", isDark);
};

const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");

const handleSystemThemeChange = () => {
    const currentAppearance = localStorage.getItem("appearance");
    applyTheme(currentAppearance || "system");
};

export function initializeTheme() {
    const savedAppearance = localStorage.getItem("appearance") || "system";

    applyTheme(savedAppearance);

    // Add the event listener for system theme changes...
    mediaQuery.addEventListener("change", handleSystemThemeChange);
}

export function useAppearance() {
    const [appearance, setAppearance] = useState < Appearance > "system";

    const updateAppearance = (mode) => {
        setAppearance(mode);
        localStorage.setItem("appearance", mode);
        applyTheme(mode);
    };

    useEffect(() => {
        const savedAppearance = localStorage.getItem("appearance");
        updateAppearance(savedAppearance || "system");

        return () =>
            mediaQuery.removeEventListener("change", handleSystemThemeChange);
    }, []);

    return { appearance, updateAppearance };
}
