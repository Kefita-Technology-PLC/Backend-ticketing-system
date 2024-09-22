import { Link } from "@inertiajs/react";
import { ReactNode } from "react";

interface PrimaryLinkProps {
  href: string;
  className?: string;
  children: ReactNode;
  [key: string]: any; // To accept other props
}

export default function PrimaryLink({
  className = "",
  children,
  href,
  ...props
}: PrimaryLinkProps) {
  return (
    <Link
      href={href}
      className={`inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-300 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition ease-in-out duration-150 ${className}`}
      {...props} // Pass other props down to the Link component
    >
      {children}
    </Link>
  );
}
