import { InputHTMLAttributes } from 'react';

export default function Checkbox({ className = '', ...props }: InputHTMLAttributes<HTMLInputElement>) {
    return (
        <input
            {...props}
            type="checkbox"
            className={`rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-400
                        focus:ring-2 dark:focus:ring-offset-gray-800 ${className}`}
        />
    );
}
