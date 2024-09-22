import { Link, InertiaLinkProps } from '@inertiajs/react';

export default function ResponsiveNavLink({
  active = false,
  className = '',
  children,
  ...props
}: InertiaLinkProps & { active?: boolean }) {
  return (
    <Link
      {...props}
      className={`w-full flex items-start px-4 py-2 border-l-4 transition duration-150 ease-in-out focus:outline-none ${
        active
          ? 'border-indigo-500 text-indigo-700 bg-indigo-50 dark:bg-indigo-900 dark:text-indigo-300'
          : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 dark:text-gray-400 dark:hover:bg-gray-700'
      } ${className}`}
    >
      {children}
    </Link>
  );
}
