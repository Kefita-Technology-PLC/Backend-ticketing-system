import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper';
import { Head } from '@inertiajs/react';
import { VehicleChart } from '../shadcn-components/ChartPie';
import { TicketSalesChart } from '../shadcn-components/LineGraph';
import { RadialChart } from '../shadcn-components/RadialChart';
import {  BarChartData } from '../shadcn-components/BarChart';

export default function Dashboard({  user,
    vehicleData, vehicleChartConfig,
    initialData, isSuperAdmin
}:{
    user:any,
    vehicleData:any, vehicleChartConfig:any,
    initialData:any, isSuperAdmin: boolean,
}) {


    return (
        <AuthenticatedLayoutSuper
            header={<h2 className="font-semibold text-xl text-gray-800 leawebding-tight">Dashboard</h2>}
        >
            <Head title="Dashboard-Super admin" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                        <VehicleChart vehicleData={vehicleData} vehicleChartConfig={vehicleChartConfig}/>
                        <TicketSalesChart initialData={initialData} />
                        <BarChartData backendData={initialData}  />
                        <RadialChart />

                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayoutSuper>
    );
}
