import { Link, InertiaLinkProps } from '@inertiajs/react';

export default function NavLink({ active = false, className = '', children, ...props }: InertiaLinkProps & { active: boolean }) {
    return (
        <Link
            {...props}
            className={
                'inline-flex items-center px-3 py-2 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none ' +
                (active
                  ? 'border-primary text-black dark:text-white focus:border-primary-dark ' // Active state: light and dark mode
                    : 'border-transparent text-muted-foreground hover:text-foreground hover:border-muted focus:text-foreground focus:border-muted-foreground dark:hover:text-muted-foreground ') + // Inactive state: light and dark mode
                className
            }
        >
            {children}
        </Link>
    );
}
