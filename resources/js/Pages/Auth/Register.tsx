import { FormEventHandler, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { Eye } from 'lucide-react';
import { EyeClosedIcon } from '@radix-ui/react-icons';

export default function Register() {
    const [showPassword, setShowPassword] = useState(false);
    const [showPassword2, setShowPassword2] = useState(false);
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        phone_no: '+251',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    const togglePasswordVisibility = () => {
        setShowPassword(!showPassword);
    };

    const togglePasswordVisibility2 = () => {
        setShowPassword2(!showPassword2);
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
                {/**Name */}
                <div>
                    <InputLabel htmlFor="name" value="Name" />

                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="name"
                        isFocused={true}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                    />

                    <InputError message={errors.name} className="mt-2" />
                </div>

                {/**Email */}
                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="phone_no" value="Phone Number" />

                    <div className='flex items-center gap-x-[2px]'>
                        <TextInput
                            id="phone_no"
                            type="text"
                            name="phone_no"
                            value={data.phone_no}
                            className="mt-1 block w-full"
                            autoComplete="current-password"
                            onChange={(e) => setData('phone_no', e.target.value)}
                        />
                    </div>

                    <InputError message={errors.phone_no} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <div className='relative'>
                        <TextInput
                            id="password"
                            type={showPassword ? "text" : "password"}
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />

                        <span
                            className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                            onClick={togglePasswordVisibility}
                        >
                            {showPassword ? <Eye size={20} /> : <EyeClosedIcon />}
                        </span>
                    </div>

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                    <div className='relative'>
                        <TextInput
                            id="password_confirmation"
                            type={showPassword2 ? "text" : "password"}
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />

                        <span
                            className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                            onClick={togglePasswordVisibility2}
                        >
                            {showPassword2 ? <Eye size={20} /> : <EyeClosedIcon />}
                        </span>
                    </div>

                    <InputError message={errors.password_confirmation} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route('login')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
