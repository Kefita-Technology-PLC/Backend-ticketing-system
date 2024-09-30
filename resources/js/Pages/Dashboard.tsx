import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

interface User{
    name: string,
    email: string,
    station?: {name: string, id: number}
}

interface DashboardProp{
    associationsCreatedBy: number,
    vehiclesCount: number,
    vehiclesCreateBy: number,
    user: { data: User} ,
    
}

export default function Dashboard({ user, vehiclesCount, vehiclesCreateBy, associationsCreatedBy }: DashboardProp) {
    return (
        <AuthenticatedLayout
            header={
            <div className='flex flex-col gap-y-2'>
                <h2 className="font-semibold text-xl text-foreground leading-tight">Dashboard</h2>
                <h2><strong>Welcome, </strong>{' '+user.data.name}</h2>
            </div>

        }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-card dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-foreground">
                            <h2 className='capitalize font-semibold '>{user.data.station?.name.replace('-', ' ')}</h2>
                            <div  className=' transition-all duration-200 flex flex-col hover:p-6 outline outline-1 rounded  shadow-lg p-4 w-[100px] mt-5'>
                                <span className=' text-center'>{vehiclesCount}</span>
                                <Link href={route('vehicles-stations.index')} className=' text-xs text-center underline '>Vehicles</Link>
                            </div>
                            <h2 className='font-semibold mt-4'>Vehicles and Associations <small> &middot; Created By You</small></h2>
                            <div  className='flex flex-col rounded outline outline-1 shadow hover:p-6 transition-all duration-200 shadow-lg p-4 w-[100px] mt-5'>
                                <span className=' text-center'>{vehiclesCreateBy || 0}</span>
                                <Link href={route('vehicles-stations.index')} className=' text-xs text-center underline'>Vehicles </Link>
                            </div>
                            <div  className='flex flex-col rounded outline outline-1 shadow hover:p-6 transition-all duration-200 shadow-lg p-4 w-[100px] mt-5'>
                                <span className=' text-center'>{associationsCreatedBy || 0}</span>
                                <Link href={route('associations-stations.index')} className=' text-xs text-center underline'>Associations </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
