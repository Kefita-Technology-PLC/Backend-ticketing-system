import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faEnvelope, faEnvelopeOpen, faMailBulk, faPhone } from '@fortawesome/free-solid-svg-icons';
import { Mail, PhoneCall } from 'lucide-react';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <img id="background" className="absolute -left-20 top-0 max-w-[877px]" src="https://laravel.com/assets/img/welcome/background.svg" />
                <div className="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header className="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                            <div className="flex lg:justify-center lg:col-start-2">
                            <svg className='text-white'  xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" width="300.000000pt" height="300.000000pt" viewBox="0 0 300.000000 300.000000">
                                <g transform="translate(0.000000,300.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                    <path d="M1020 1873 c0 -159 4 -263 9 -257 5 5 59 76 120 158 l111 150 0 108
                                    0 108 -120 0 -120 0 0 -267z m193 225 c14 -7 17 -22 17 -79 0 -83 -2 -86 -93
                                    -207 -47 -62 -73 -89 -78 -80 -7 14 -10 323 -3 350 7 24 116 35 157 16z"/>

                                    <path d="M1487 2045 c-36 -49 -156 -211 -266 -360 l-201 -269 0 -276 0 -275
                                    120 0 120 0 0 173 0 173 322 437 c176 240 329 446 340 458 10 11 18 23 18 27
                                    0 4 -87 6 -194 4 l-193 -2 -66 -90z m370 45 c2 -8 -31 -60 -71 -115 -41 -55
                                    -88 -118 -104 -140 -50 -68 -293 -397 -333 -450 -21 -27 -56 -77 -78 -110
                                    l-41 -60 0 -142 c0 -78 -3 -148 -6 -157 -5 -13 -22 -16 -84 -16 -78 0 -78 0
                                    -84 28 -4 21 -1 384 3 473 1 8 42 69 91 135 50 65 106 142 125 169 19 28 92
                                    127 162 220 l128 170 50 5 c28 3 93 5 145 5 75 -1 95 -4 97 -15z"/>
                                    <path d="M1529 1352 c-15 -20 -42 -57 -60 -81 -32 -43 -32 -44 -6 -26 15 9 27
                                    23 27 29 0 19 55 76 73 76 10 0 17 -4 17 -9 0 -7 36 -58 70 -98 6 -7 24 -32
                                    40 -56 16 -24 37 -50 47 -58 16 -12 17 -12 7 1 -6 8 -45 62 -87 120 -42 58
                                    -82 113 -89 122 -12 16 -15 14 -39 -20z"/>
                                    <path d="M1399 1174 c-19 -25 -33 -49 -32 -53 7 -19 98 -131 101 -123 2 6 -7
                                    21 -20 35 -74 80 -76 98 -25 154 11 13 18 25 15 29 -3 3 -21 -16 -39 -42z"/>
                                    <path d="M1761 1089 c6 -13 25 -37 41 -53 15 -17 28 -35 28 -41 0 -6 14 -24
                                    31 -41 21 -20 11 -1 -31 59 -61 86 -94 121 -69 76z"/>
                                    <path d="M1486 958 c19 -32 68 -88 77 -88 5 0 -2 12 -17 26 -14 15 -26 33 -26
                                    40 0 7 -10 18 -21 25 -17 9 -20 8 -13 -3z"/>
                                    <path d="M1893 901 c4 -17 -1 -20 -37 -23 -35 -3 -33 -4 20 -8 l62 -5 -20 28
                                    c-23 32 -32 35 -25 8z"/>
                                </g>
                            </svg>
                            </div>
                            <nav className="-mx-3 flex flex-1 justify-end">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white bg-black text-white dark:bg-white dark:text-black hover:bg-slate-700 hover:text-white dark:hover:bg-slate-200 dark:text-white"
                                        >
                                            Log in
                                        </Link>
                                        {/* <Link
                                            href={route('register')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link> */}
                                    </>
                                )}
                            </nav>
                        </header>

                        <main className="mt-6">
                            <div className="grid gap-6 lg:grid-cols-2 lg:gap-8 max-w-2xl px-6 lg:max-w-7xl">
                                <div>
                                    <h2 className=' text-3xl font-semibold text-black dark:text-white text-center'>Kefita Technologies Digital Ticketing System</h2>
                                </div>
                                <div className='flex justify-center gap-x-2 items-center '>
                                    Contact us
                                    <a href="mailto:#" className='hover:bg-black hover:text-white p-3 rounded-sm transition'>
                                        <FontAwesomeIcon icon={faEnvelope} />
                                    </a>
                                   
                                   <a href="tel:+251#" className='hover:bg-black hover:text-white p-3 rounded-sm transition'>
                                    <FontAwesomeIcon 
                                        icon={faPhone}
                                    />
                                   </a>
                                </div>
                            </div>
                        </main>

                        <footer className="py-16 text-center  gap-x-5 text-black dark:text-white/70 text-xs">
                            Copyright@  2024
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}
