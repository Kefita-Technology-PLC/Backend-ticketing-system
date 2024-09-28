import { lazy, Suspense } from 'react';
import Pagination from '@/Components/Pagination';
import PrimaryLink from '@/Components/PrimaryLink';
import SelectInput from '@/Components/SelectInput';
import TextInput from '@/Components/TextInput';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/Components/ui/table';
import { ChevronUpIcon, ChevronDownIcon } from '@radix-ui/react-icons';
import { Head, Link, router } from '@inertiajs/react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { SelectGroup, SelectLabel } from '@radix-ui/react-select';
import { SelectItem } from '@/Components/ui/select';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons';
import {toast} from 'sonner'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PermissionAlert from '@/Components/PermissionAlert';
import { Divide } from 'lucide-react';

const EditAlert = lazy(()=>import('./EditAlert'))
const DeleteAlert = lazy(() => import('./DeleteAlert'));

dayjs.extend(relativeTime);

interface Vehicle {
  id: number;
  code: number;
  region: string;
  plate_number: string;
  level: string;
  station_id: number,
  association_id: number,
  origin: string,
  destination: string,
  number_of_passengers: string,
  car_type: string;
  created_at: string;
  updated_at: string;
  creator?: { name: string };
  updater?: { name: string };
}

interface VehiclesResponse {
  data: Vehicle[];
  links: any;
  meta: { links: any[] }; // Adjust according to your API response
}

interface IndexProps {
  vehicles: VehiclesResponse;
  queryParams?: any;
  success?: string,
  stationName: string,
  addVehicle: boolean,
  updateVehicle: boolean,
  deleteVehicle: boolean,
}

function Index({ 
  vehicles, 
  queryParams = {}, 
  success,
  addVehicle,
  updateVehicle,
  deleteVehicle,
  stationName,
}: IndexProps) {

  queryParams = queryParams || {}

  if(success){
    toast(success)
  }
  
  const searchFieldChanged = (name: string, value: any) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }
    router.get(route('vehicles-stations.index'), queryParams);
  };

  const onKeyDown = (name: string, e: any) => {
    if (e.key !== 'Enter') return;
    searchFieldChanged(name, e.target.value);
  };

  const sortChanged = (name: string) => {
    if (name === queryParams.sort_field) {
      queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = 'asc';
    }
    router.get(route('vehicles-stations.index'), queryParams);
  };

  const codeColor = (code: number) => {
    switch (code) {
      case 1:
        return 'text-red-500';
      case 2:
        return 'text-blue-500';
      case 3:
        return 'text-green-500';
      default:
        return 'text-gray-500';
    }
  };

  return (
    <AuthenticatedLayout header={
      <div className='flex justify-between'>
        <div className='flex flex-col'>
          <strong className=' capitalize text-xl'>{stationName.replace('-', ' ')}</strong>
          <h1>Vehicles</h1>
        </div>
        {
          addVehicle ? <PrimaryLink className=' self-center' href={route('vehicles-stations.create')}>Add Vehicle</PrimaryLink> : <PermissionAlert children={'Add Vehicle'} permission='add vehicle' />
        }

      </div>
    }>
      <Head title="Vehicles" />

      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <Table>
                <TableCaption>A list of vehicles</TableCaption>

                <TableHeader>
                  <TableRow>
                    {/* Column Headers with Sorting */}
                    <TableHead onClick={() => sortChanged('id')}>#No</TableHead>
                    <TableHead onClick={() => sortChanged('code')}>
                      <div className='flex items-center gap-x-1'>
                        Code
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-2' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead onClick={() => sortChanged('plate_number')}>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Plate Number</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-2' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead>Level</TableHead>
                    <TableHead>Car Type</TableHead>
                    <TableHead onClick={()=> sortChanged('created_at')}>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Registerd At</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-2' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead className=' text-nowrap'>Edited</TableHead>
                    <TableHead className=' text-nowrap'>Created By</TableHead>
                    <TableHead className=' text-nowrap'>Updated By</TableHead>
                    <TableHead className=' text-nowrap'>Actions</TableHead>
                  </TableRow>
                </TableHeader>

                <TableHeader>
                  <TableRow>
                    {/* Search Inputs */}
                    <TableHead></TableHead>
                    <TableHead></TableHead>
                    <TableHead>
                      <TextInput
                        className="w-full"
                        placeholder="Plate Number"
                        defaultValue={queryParams.plate_number}
                        onBlur={(e) => searchFieldChanged('plate_number', e.target.value)}
                        onKeyDown={(e) => onKeyDown('plate_number', e)}
                      />
                    </TableHead>
                    <TableHead>
                      <SelectInput
                        value={queryParams.level}
                        onChange={(value) => searchFieldChanged('level', value)}
                      >
                        <SelectGroup>
                          <SelectLabel>Levels</SelectLabel>
                          <SelectItem value="level_1">Level 1</SelectItem>
                          <SelectItem value="level_2">Level 2</SelectItem>
                          <SelectItem value="level_3">Level 3</SelectItem>
                          <SelectItem value="level_4">Level 4</SelectItem>
                        </SelectGroup>
                      </SelectInput>
                    </TableHead>
                    <TableHead>
                      <SelectInput
                        value={queryParams.car_type}
                        onChange={(value) => searchFieldChanged('car_type', value)}
                      >
                        <SelectGroup>
                          <SelectLabel>Car Types</SelectLabel>
                          <SelectItem value="bus">Bus</SelectItem>
                          <SelectItem value="mini_bus">Mini Bus</SelectItem>
                          <SelectItem value="lonchin">Lonchin</SelectItem>
                          <SelectItem value="higer">Higer</SelectItem>
                        </SelectGroup>
                      </SelectInput>
                    </TableHead>
                    <TableHead></TableHead>
                    <TableHead></TableHead>
                    <TableHead></TableHead>
                    <TableHead></TableHead>
                  </TableRow>
                </TableHeader>

                <TableBody>
                  {vehicles.data.map((vehicle, index) => (
                    <TableRow key={vehicle.id}>
                      <TableCell>{index + 1}</TableCell>
                      <TableCell className={codeColor(vehicle.code)}>{vehicle.code}</TableCell>
                      <TableCell>
                        <Link href={route('vehicles.show', vehicle.id)} className='hover:underline'>
                          {vehicle.region + '-' + vehicle.plate_number}
                        </Link>
                      </TableCell>
                      <TableCell>{vehicle.level ? vehicle.level.replace('_', ' ') : ''}</TableCell>
                      <TableCell>{vehicle.car_type ? vehicle.car_type.replace('_', ' ') : ''}</TableCell>
                      <TableCell className='text-nowrap'>{dayjs(vehicle.created_at).fromNow()}</TableCell>
                      <TableCell className=' text-nowrap'>
                        {vehicle.created_at == vehicle.updated_at ? (
                          'No'
                        ) : (
                          <span className="flex items-center">
                            Edited <FontAwesomeIcon icon={faCheckCircle} className="w-4 ml-1" /> <small className='mx-1'> &middot;</small>
                            {dayjs(vehicle.updated_at).fromNow()}
                          </span>
                        )}
                      </TableCell>
                      <TableCell className='text-nowrap'>{vehicle.creator?.name || 'N/A'}</TableCell>
                      <TableCell className='text-nowrap'>{vehicle.updater?.name || 'N/A'}</TableCell>
                      <TableCell className='flex items-center gap-x-2'>
                        {
                          updateVehicle ? 
                          <Suspense fallback={<div>Loading...</div>}>
                             <EditAlert vehicle={vehicle} /> 
                          </Suspense>
                          : <PermissionAlert children={'Edit'} permission='edit' />
                        }
                        {
                          deleteVehicle ?  
                          <Suspense fallback={<div>Loading...</div>}>
                            <DeleteAlert vehicle={vehicle} /> 
                          </Suspense>
                          : <PermissionAlert className='bg-red-500 text-white capitalize hover:bg-red-400 hover:cursor-pointer' children={'Delete'} permission=' delete' />
                        }
                       
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          </div>
        </div>
      </div>
      <Pagination links={vehicles.meta.links} />
    </AuthenticatedLayout>
  );
}

export default Index;
