import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper';
import { Head } from '@inertiajs/react';
import { VehicleChart } from '../shadcn-components/ChartPie';
import { LineGraph } from '../shadcn-components/LineGraph';
import { RadialChart } from '../shadcn-components/RadialChart';

export default function Dashboard({user, vehicleData, vehicleChartConfig}:{user:any, vehicleData:any, vehicleChartConfig:any}) {


    return (
        <AuthenticatedLayoutSuper
            header={<h2 className="font-semibold text-xl text-gray-800 leawebding-tight">Dashboard</h2>}
        >
            <Head title="Dashboard-Super admin" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">{JSON.stringify(user)}
                        <VehicleChart vehicleData={vehicleData} vehicleChartConfig={vehicleChartConfig}/>
                        <LineGraph />
                        <RadialChart />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayoutSuper>
    );
}
