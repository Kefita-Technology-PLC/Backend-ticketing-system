import { forwardRef, useEffect, useImperativeHandle, useRef, InputHTMLAttributes } from 'react';

export default forwardRef(function TextInput(
    { type = 'text', className = '', isFocused = false, ...props }: InputHTMLAttributes<HTMLInputElement> & { isFocused?: boolean },
    ref
) {
    const localRef = useRef<HTMLInputElement>(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus();
        }
    }, [isFocused]);

    return (
        <input
            {...props}
            type={type}
            className={
                'border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' +
                'dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 ' +
                className
            }
            ref={localRef}
        />
    );
});
