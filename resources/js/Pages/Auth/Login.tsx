import { useState } from 'react';
import { FormEventHandler } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { Eye } from 'lucide-react';
import { EyeClosedIcon } from '@radix-ui/react-icons';

export default function Login({ status, canResetPassword }: { status?: string, canResetPassword: boolean }) {
    const [showPassword, setShowPassword] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        phone_no: '+251',
        remember: false,
    });

    const togglePasswordVisibility = () => {
        setShowPassword(!showPassword);
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 font-medium text-sm text-green-600 dark:text-green-400">{status}</div>}

            <form onSubmit={submit}>
                <div className="mt-4">
                    <InputLabel htmlFor="phone_no" value="Phone Number" className="dark:text-gray-300" />

                    <TextInput
                        id="phone_no"
                        type="text"
                        name="phone_no"
                        value={data.phone_no}
                        className="mt-1 block w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
                        autoComplete="current-password"
                        onChange={(e) => setData('phone_no', e.target.value)}
                    />

                    <InputError message={errors.phone_no} className="mt-2 dark:text-red-400" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" className="dark:text-gray-300" />

                    <div className="relative">
                        <TextInput
                            id="password"
                            type={showPassword ? "text" : "password"}
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                        />

                        <span
                            className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                            onClick={togglePasswordVisibility}
                        >
                            {showPassword ? <Eye size={20} className="dark:text-gray-400" /> : <EyeClosedIcon />}
                        </span>
                    </div>

                    <InputError message={errors.password} className="mt-2 dark:text-red-400" />
                </div>

                <div className="block mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700"
                        />
                        <span className="ms-2 text-sm text-gray-600 dark:text-gray-300">Remember me</span>
                    </label>
                </div>

                <div className="flex items-center justify-end mt-4">
                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="underline text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-300"
                        >
                            Forgot your password?
                        </Link>
                    )}

                    {/* <Link
                        href={route('register')}
                        className="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-300 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer ms-4"
                    >
                        Register
                    </Link> */}

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
