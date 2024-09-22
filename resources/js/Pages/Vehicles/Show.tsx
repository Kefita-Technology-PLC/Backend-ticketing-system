import AuthenticatedLayoutSuper from "@/Layouts/AuthenticatedLayoutSuper";
import { Head, Link } from "@inertiajs/react";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

interface association {
  id: number,
  name: string,
}

interface station {
  id: number,
  name: string,
}

interface vehicle {
  id: number;
  code: number;
  association: association,
  station: station,
  region: string;
  plate_number: string;
  level: string;
  car_type: string;
  number_of_passengers: number,
  created_at: string;
  updated_at: string;
  creator?: { name: string };
  updater?: { name: string };
}

function Show({ vehicle }: { vehicle: vehicle }) {
  return (
    <AuthenticatedLayoutSuper header={'Show Vehicle'}>
      <Head title="Show Vehicle"></Head>
      <div className="py-12">
        <div className="max-w-5xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-8 space-y-6 text-gray-900 dark:text-gray-100">

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                <div>
                  <strong className="block font-semibold">Vehicle Plate Number:</strong>
                  <em className="text-lg">{vehicle.plate_number}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Vehicle Plate Code:</strong>
                  <em className="text-lg">{vehicle.code}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Region:</strong>
                  <em className="capitalize">{vehicle.region}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Station:</strong>
                  <Link
                    href={route('stations.show', vehicle.station.id)}
                    className="capitalize hover:underline text-blue-500 dark:text-blue-400"
                  >
                    {vehicle.station.name.replace('-', ' ')}
                  </Link>
                </div>

                <div>
                  <strong className="block font-semibold">Association:</strong>
                  <Link
                    href={route('associations.show', vehicle.association.id)}
                    className="capitalize hover:underline text-blue-500 dark:text-blue-400"
                  >
                    {vehicle.association.name.replace('-', ' ')}
                  </Link>
                </div>

                <div>
                  <strong className="block font-semibold">Vehicle Type:</strong>
                  <em>{vehicle.car_type}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Vehicle Level:</strong>
                  <em>{vehicle.level}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Passenger Capacity:</strong>
                  <em>{vehicle.number_of_passengers}</em>
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                <div>
                  <strong className="block font-semibold">Created By:</strong>
                  <em>{vehicle.creator?.name ?? 'N/A'}</em>
                </div>

                <div>
                  <strong className="block font-semibold">Updated By:</strong>
                  <em>{vehicle.updater?.name ?? 'N/A'}</em>
                  <span className="block text-sm text-gray-500 dark:text-gray-400">
                    Updated {dayjs(vehicle.updated_at).fromNow()}
                  </span>
                </div>

                <div className="sm:col-span-2">
                  <strong className="block font-semibold">Registered On:</strong>
                  <em className="block text-sm text-gray-500 dark:text-gray-400">
                    {dayjs(vehicle.created_at).fromNow()}
                  </em>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayoutSuper>
  )
}

export default Show;
