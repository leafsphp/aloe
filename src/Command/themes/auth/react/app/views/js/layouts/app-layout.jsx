import { useState } from "react";
import { Breadcrumbs } from "@/components/shared/breadcrumbs";
import {
    SidebarProvider,
    SidebarInset,
    SidebarTrigger,
} from "../components/layout/sidebar";
import { AppHeader } from "../components/layout/header";

export default function AppLayout({
    children,
    breadcrumbs,
    variant = "sidebar",
    ...props
}) {
    const [isOpen, setIsOpen] = useState(() =>
        typeof window !== "undefined"
            ? localStorage.getItem("sidebar") !== "false"
            : true,
    );

    const handleSidebarChange = (open) => {
        setIsOpen(open);

        if (typeof window !== "undefined") {
            localStorage.setItem("sidebar", String(open));
        }
    };

    if (variant === "header") {
        return (
            <div className="flex min-h-screen w-full flex-col">
                <AppHeader breadcrumbs={breadcrumbs} />
                <main
                    className="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl"
                    {...props}
                >
                    {children}
                </main>
            </div>
        );
    }

    return (
        <SidebarProvider
            defaultOpen={isOpen}
            open={isOpen}
            onOpenChange={handleSidebarChange}
        >
            <AppHeader variant="sidebar" breadcrumbs={breadcrumbs} />
            <SidebarInset variant="sidebar" {...props}>
                <header className="border-sidebar-border/50 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
                    <div className="flex items-center gap-2">
                        <SidebarTrigger className="-ml-1 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0" />
                        <Breadcrumbs breadcrumbs={breadcrumbs} />
                    </div>
                </header>

                {children}
            </SidebarInset>
        </SidebarProvider>
    );
}
