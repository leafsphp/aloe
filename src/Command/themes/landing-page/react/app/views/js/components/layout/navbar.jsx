import { Link } from "@inertiajs/react";
import { NavigationMenu, NavigationMenuList, NavigationMenuItem, NavigationMenuTrigger, NavigationMenuContent, NavigationMenuLink } from "./navigation-menu";
import Button from "../form/button";
import { Sheet, SheetTrigger, SheetContent, SheetHeader, SheetTitle } from "./sheet";
import { Book, Menu, Sunset, Trees, Zap } from "lucide-react";

const Navbar = ({
    logo = {
        url: "/",
        src: "#",
        alt: "logo",
        title: "LOGO",
    },
    menu = [
        // {
        //     title: "Products",
        //     url: "#",
        //     items: [
        //         {
        //             title: "Blog",
        //             description: "The latest industry news, updates, and info",
        //             icon: <Book className="size-5 shrink-0" />,
        //             url: "#",
        //         },
        //         {
        //             title: "Company",
        //             description: "Our mission is to innovate and empower the world",
        //             icon: <Trees className="size-5 shrink-0" />,
        //             url: "#",
        //         },
        //         {
        //             title: "Careers",
        //             description: "Browse job listing and discover our workspace",
        //             icon: <Sunset className="size-5 shrink-0" />,
        //             url: "#",
        //         },
        //         {
        //             title: "Support",
        //             description:
        //                 "Get in touch with our support team or visit our community forums",
        //             icon: <Zap className="size-5 shrink-0" />,
        //             url: "#",
        //         },
        //     ],
        // },
        {
            title: "Pricing",
            url: "/pricing",
        },
        {
            title: "FAQs",
            url: "#",
        },
    ],
    auth,
}) => {
    return (
        <header className="py-4 fixed top-0 left-0 w-full bg-background shadow-xs dark:shadow-primary-orange/20 z-50 backdrop-blur-2xl backdrop-opacity-20 flex justify-center items-center">
            <div className="container">
                {/* Desktop Menu */}
                <nav className="hidden justify-between lg:flex">
                    <div className="flex items-center gap-6">
                        <a href={logo.url} className="flex items-center gap-2">
                            {/* <img
                                src={logo.src}
                                className="size-5"
                                alt={logo.alt}
                            /> */}
                            <span className="text-lg font-semibold">
                                {logo.title}
                            </span>
                        </a>
                        <div className="flex items-center">
                            <NavigationMenu>
                                <NavigationMenuList>
                                    {menu.map((item) => renderMenuItem(item))}
                                </NavigationMenuList>
                            </NavigationMenu>
                        </div>
                    </div>
                    <div className="flex gap-2">
                        {auth.user ? (
                            <Button asChild variant="outline" size="sm">
                                <Link href="/dashboard">Dashboard</Link>
                            </Button>
                        ) : (
                            <>
                                <Button asChild variant="outline" size="sm">
                                    <Link href="/auth/login">Login</Link>
                                </Button>
                                <Button asChild size="sm" className="bg-primary-red hover:bg-primary-red/80 text-white">
                                    <Link href="/auth/register">Sign up</Link>
                                </Button>
                            </>
                        )}
                    </div>
                </nav>
                {/* Mobile Menu */}
                <div className="block lg:hidden">
                    <div className="flex items-center justify-between">
                        <a href={logo.url} className="flex items-center gap-2">
                            <img
                                src={logo.src}
                                className="w-8"
                                alt={logo.alt}
                            />
                            <span className="text-lg font-semibold">
                                {logo.title}
                            </span>
                        </a>
                        <Sheet>
                            <SheetTrigger asChild>
                                <Button variant="outline" size="icon">
                                    <Menu className="size-4" />
                                </Button>
                            </SheetTrigger>
                            <SheetContent className="overflow-y-auto">
                                <SheetHeader>
                                    <SheetTitle>
                                        <a
                                            href={logo.url}
                                            className="flex items-center gap-2"
                                        >
                                            <img
                                                src={logo.src}
                                                className="w-8"
                                                alt={logo.alt}
                                            />
                                            <span className="text-lg font-semibold">
                                                {logo.title}
                                            </span>
                                        </a>
                                    </SheetTitle>
                                </SheetHeader>
                                <div className="flex flex-col gap-6 p-4">
                                    {/* <Accordion
                                        type="single"
                                        collapsible
                                        className="flex w-full flex-col gap-4"
                                    >
                                        {menu.map((item) =>
                                            renderMobileMenuItem(item),
                                        )}
                                    </Accordion> */}

                                    <div className="flex flex-col gap-3">
                                        <Button asChild variant="outline">
                                            <Link href="/auth/login">
                                                Login
                                            </Link>
                                        </Button>
                                        <Button asChild>
                                            <Link href="/auth/register">
                                                Sign up
                                            </Link>
                                        </Button>
                                    </div>
                                </div>
                            </SheetContent>
                        </Sheet>
                    </div>
                </div>
            </div>
        </header>
    );
};

const renderMenuItem = (item) => {
    if (item.items) {
        return (
            <NavigationMenuItem key={item.title} className="text-muted-foreground">
                <NavigationMenuTrigger>{item.title}</NavigationMenuTrigger>
                <NavigationMenuContent>
                    {item.items.map((subItem) => (
                        <NavigationMenuLink asChild key={subItem.title} className="w-80">
                            <SubMenuLink item={subItem} />
                        </NavigationMenuLink>
                    ))}
                </NavigationMenuContent>
            </NavigationMenuItem>
        );
    }

    return (
        <a
            key={item.title}
            className="group inline-flex h-10 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-accent-foreground"
            href={item.url}
        >
            {item.title}
        </a>
    );
};

const renderMobileMenuItem = (item) => {
    if (item.items) {
        return (
            <AccordionItem key={item.title} value={item.title} className="border-b-0">
                <AccordionTrigger className="text-md py-0 font-semibold hover:no-underline">
                    {item.title}
                </AccordionTrigger>
                <AccordionContent className="mt-2">
                    {item.items.map((subItem) => (
                        <SubMenuLink key={subItem.title} item={subItem} />
                    ))}
                </AccordionContent>
            </AccordionItem>
        );
    }

    return (
        <a key={item.title} href={item.url} className="text-md font-semibold">
            {item.title}
        </a>
    );
};

const SubMenuLink = ({ item }) => {
    return (
        <a
            className="flex flex-row gap-4 rounded-md p-3 leading-none no-underline transition-colors outline-none select-none hover:bg-muted hover:text-accent-foreground"
            href={item.url}
        >
            <div>{item.icon}</div>
            <div>
                <div className="text-sm font-semibold">{item.title}</div>
                {item.description && (
                    <p className="text-sm leading-snug text-muted-foreground">
                        {item.description}
                    </p>
                )}
            </div>
        </a>
    );
};

export default Navbar;
