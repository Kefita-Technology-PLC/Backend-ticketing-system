import Pagination from '@/Components/Pagination';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/Components/ui/table';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Head } from '@inertiajs/react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

function Index({ vehicles }: { vehicles: any }) {
  const codeColor = (code: any) => {
    switch (code) {
      case 1:
        return 'text-red-500';
      case 2:
        return 'text-blue-500';
      case 3:
        return 'text-green-500';
      default:
        return 'text-gray-500'; // Default color for undefined codes
    }
  };

  return (
    <AuthenticatedLayout header={'Vehicles'}>
      <Head title="Vehicles" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-900 overflow-hidden shadow sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <Table>
                <TableCaption>A list of vehicles</TableCaption>

                <TableHeader>
                  <TableRow>
                    <TableHead className="whitespace-nowrap">#No</TableHead>
                    <TableHead className="whitespace-nowrap">Code</TableHead>
                    <TableHead className="whitespace-nowrap">Plate Number</TableHead>
                    <TableHead className="whitespace-nowrap">Level</TableHead>
                    <TableHead className="whitespace-nowrap">Car Type</TableHead>
                    <TableHead className="whitespace-nowrap">Registered At</TableHead>
                    <TableHead className="whitespace-nowrap">Edited</TableHead>
                    <TableHead className="whitespace-nowrap">Created By</TableHead>
                    <TableHead className="whitespace-nowrap">Updated By</TableHead>
                  </TableRow>
                </TableHeader>

                <TableBody>
                  {vehicles.data.map((vehicle: any, index: number) => (
                    <TableRow key={vehicle.id}>
                      <TableCell>{index + 1}</TableCell>
                      <TableCell className={codeColor(vehicle.code)}>
                        {vehicle.code}
                      </TableCell>
                      <TableCell>{vehicle.plate_number}</TableCell>
                      <TableCell className="capitalize">
                        {vehicle.level.replace('_', ' ')}
                      </TableCell>
                      <TableCell className="capitalize">
                        {vehicle.car_type.replace('_', ' ')}
                      </TableCell>
                      <TableCell>{dayjs(vehicle.created_at).fromNow()}</TableCell>
                      <TableCell>
                        {vehicle.created_at !== vehicle.updated_at ? (
                          'No'
                        ) : (
                          <span className="flex items-center">
                            Edited <FontAwesomeIcon icon={faCheckCircle} className="ml-1" />
                          </span>
                        )}
                      </TableCell>
                      <TableCell>{vehicle.creator?.name || 'N/A'}</TableCell>
                      <TableCell>{vehicle.updater?.name || 'N/A'}</TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          </div>
        </div>
      </div>
      <Pagination links={vehicles.links} />
    </AuthenticatedLayout>
  );
}

export default Index;
