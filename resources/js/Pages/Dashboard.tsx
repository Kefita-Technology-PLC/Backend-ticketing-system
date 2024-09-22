import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ user }: { user: any }) {
    return (
        <Authenticated
            header={<h2 className="font-semibold text-xl text-foreground leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-card dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-foreground">{JSON.stringify(user)}</div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
