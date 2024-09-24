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
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper';
import { ChevronUpIcon, ChevronDownIcon } from '@radix-ui/react-icons';
import { Head, Link, router } from '@inertiajs/react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { SelectGroup, SelectLabel } from '@radix-ui/react-select';
import { SelectItem } from '@/Components/ui/select';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCheckCircle } from '@fortawesome/free-solid-svg-icons';
import { useEffect } from 'react';
import {toast} from 'sonner'
import Dropdown from '@/Components/Dropdown';

dayjs.extend(relativeTime);

interface Vehicle {
  id: number;
  code: number;
  region: string;
  plate_number: string;
  level: string;
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
  success: string
}

function Index({ vehicles, queryParams = {}, success}: IndexProps) {

  queryParams = queryParams || {}

  const searchFieldChanged = (name: string, value: any) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }
    router.get(route('vehicles.index'), queryParams);
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
    router.get(route('vehicles.index'), queryParams);
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

  useEffect(()=>{
    success ? toast(success): ''
  },[])

  return (
    <AuthenticatedLayoutSuper header={
      <div className='flex justify-between'>
        <h1>Vehicles</h1>
        <PrimaryLink href={route('vehicles.create')}>Add Vehicle</PrimaryLink>
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
                      <TableCell>
                        {vehicle.created_at == vehicle.updated_at ? (
                          'No'
                        ) : (
                          <span className="flex items-center">
                            Edited <FontAwesomeIcon icon={faCheckCircle} className="w-4 ml-1" />
                          </span>
                        )}
                      </TableCell>
                      <TableCell className='text-nowrap'>{vehicle.creator?.name || 'N/A'}</TableCell>
                      <TableCell className='text-nowrap'>{vehicle.updater?.name || 'N/A'}</TableCell>
                      <TableCell>
                        <Dropdown>
                          <Dropdown.Trigger>
                            <button>
                              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                              </svg>
                            </button>
                          </Dropdown.Trigger>

                          <Dropdown.Content>
                            <Dropdown.Link 
                              as='button'
                              href={route('vehicles.edit',vehicle.id)}
                              method='get'
                            >
                              Edit
                            </Dropdown.Link>
                            <Dropdown.Link as='button' href={route('vehicles.destroy',vehicle.id )} method="delete">
                              Delete
                            </Dropdown.Link>
                          </Dropdown.Content>
                        </Dropdown>
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
    </AuthenticatedLayoutSuper>
  );
}

export default Index;
