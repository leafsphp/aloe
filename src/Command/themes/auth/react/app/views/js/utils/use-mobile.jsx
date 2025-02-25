import { useEffect, useState, useCallback } from "react";

const MOBILE_BREAKPOINT = 768;

export function useIsMobile() {
    const [isMobile, setIsMobile] = useState(undefined);

    useEffect(() => {
        const mql = window.matchMedia(
            `(max-width: ${MOBILE_BREAKPOINT - 1}px)`,
        );

        const onChange = () => {
            setIsMobile(window.innerWidth < MOBILE_BREAKPOINT);
        };

        mql.addEventListener("change", onChange);
        setIsMobile(window.innerWidth < MOBILE_BREAKPOINT);

        return () => mql.removeEventListener("change", onChange);
    }, []);

    return !!isMobile;
}

export function useMobileNavigation() {
    const cleanup = useCallback(() => {
        // Remove pointer-events style from body...
        document.body.style.removeProperty("pointer-events");
    }, []);

    return cleanup;
}
