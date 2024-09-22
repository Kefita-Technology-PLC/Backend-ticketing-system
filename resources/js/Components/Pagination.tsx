import { Link } from "@inertiajs/react";

function Pagination({ links }: { links: any }) {
  return (
    <nav className="flex justify-center mt-4">
      {links.map((link: any) => {
        return (
          <Link
            preserveScroll
            key={link.label}
            className={`inline-flex items-center py-2 px-3 rounded-lg text-xs transition duration-150 ease-in-out ${
              link.active
                ? "bg-gray-950 text-white dark:bg-gray-200 dark:text-gray-900"
                : "text-gray-600 dark:text-gray-400"
            } ${
              !link.url
                ? "text-gray-500 cursor-not-allowed"
                : "hover:bg-gray-950 hover:text-white dark:hover:bg-gray-700 dark:hover:text-gray-100"
            }`}
            dangerouslySetInnerHTML={{ __html: link.label }}
            href={link.url || ""}
          />
        );
      })}
    </nav>
  );
}

export default Pagination;
