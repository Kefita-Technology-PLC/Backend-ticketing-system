import PrimaryLink from "@/Components/PrimaryLink"
import TextInput from "@/Components/TextInput";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/Components/ui/table';
import AuthenticatedLayoutSuper from "@/Layouts/AuthenticatedLayoutSuper" 
import { Head, router } from "@inertiajs/react"
import { ChevronDownIcon, ChevronUpIcon } from "lucide-react";
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheckCircle } from "@fortawesome/free-solid-svg-icons";
import Pagination from "@/Components/Pagination";
import { CreateAlert } from "./CreateAlert";
import { toast } from "sonner";
import UpdateAlert from "./UpdateAlert";
import DeleteAlert from "./DeleteAlert";

dayjs.extend(relativeTime);

interface Station{
  id: number,
  name: string,
  location: string,
  created_at: string,
  updated_at: string,
  creator?: {name: string},
  updater?: {name: string},
}

interface StationResponse {
  data: Station[],
  links: any,
  meta: {links: any[]},
}

interface IndexProps {
  stations: StationResponse;
  queryParams?: any;
  success: string
}

function Index({stations, queryParams = {}, success}: IndexProps) {

  
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
    router.get(route('all-stations.index'), queryParams);
  };


  const sortChanged = (name: string) => {
    if (name === queryParams.sort_field) {
      queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = 'asc';
    }
    router.get(route('all-stations.index'), queryParams);
  };

  const onKeyDown = (name: string, e: any) => {
    if (e.key !== 'Enter') return;
    searchFieldChanged(name, e.target.value);
  };

  return (
    <AuthenticatedLayoutSuper header={
      <div className='flex justify-between'>
      <h1>Station</h1>
        <CreateAlert />
    </div>
    }>
      <Head title='Stations' />
      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
            <Table>
              <TableCaption >A list of Stations</TableCaption>

              <TableHeader>
                <TableRow>
                  <TableHead 
                    onClick={()=> sortChanged('id')}
                    className="text-nowrap"
                  >
                    <div className='flex items-center gap-x-1'>
                      #No
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>
                  <TableHead
                    onClick={()=> sortChanged('name')}
                  >
                    <div className='flex items-center gap-x-1'>
                      Name
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>
                  <TableHead
                    onClick={()=> sortChanged('location')}
                  >
                    <div className='flex items-center gap-x-1'>
                      Location
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>
                  <TableHead>Edited</TableHead>
                  <TableHead className=" text-nowrap">Created At</TableHead>
                  <TableHead className=" text-nowrap">Updated At</TableHead>
                  <TableHead>Creator</TableHead>
                  <TableHead>Updater</TableHead>
                  <TableHead>Actions</TableHead>
                </TableRow>

              </TableHeader>

              <TableHeader>
                <TableRow>
                  <TableHead></TableHead>
                  <TableHead>
                    <TextInput 
                      className="w-full"
                      placeholder="Name"
                      defaultValue={queryParams.name}
                      onBlur={(e)=>searchFieldChanged('name', e.target.value)}
                      onKeyDown={(e)=> onKeyDown('name', e)}
                    />
                  </TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                  <TableHead></TableHead>
                </TableRow>

              </TableHeader>

              <TableBody>
                {stations.data.map((station, index)=>(
                  <TableRow key={station.id}>
                    <TableCell>{index + 1}</TableCell>
                    <TableCell className=" text-nowrap">{station.name}</TableCell>
                    <TableCell className=" text-nowrap">{station.location}</TableCell>
                    <TableCell className='text-nowrap'>
                        {station.created_at == station.updated_at ? (
                          'No'
                        ) : (
                          <div className="flex flex-col">
                            <span>Edited <FontAwesomeIcon icon={faCheckCircle} className="w-4 ml-1" /></span>
                            <span>({dayjs(station.updated_at).fromNow()})</span>
                          </div>
                        )}
                    </TableCell>
                    <TableCell className=" text-nowrap ">
                      <div className="flex flex-col items-center">
                        <span>{new Date(station.created_at).toLocaleDateString()}</span>
                        <span>({dayjs(station.created_at).fromNow()})</span>
                      </div>
                  </TableCell>

                    <TableCell className=" text-nowrap">
                      <div className="flex flex-col items-center">
                        <span>{new Date(station.updated_at).toLocaleDateString()}</span>
                        <span>({dayjs(station.updated_at).fromNow()})</span>
                      </div>
                    </TableCell>
                    <TableCell className=" text-nowrap">{station.creator?.name||'N/A'}</TableCell>
                    <TableCell className=" text-nowrap">{station.updater?.name||'N/A'}</TableCell>
                    <TableCell className=" text-nowrap flex items-center gap-x-3">
                      <UpdateAlert station={station} />
                      <DeleteAlert station={station} />
                    </TableCell>

                  </TableRow>
                ))}
              </TableBody>

            </Table>
          </div>

        </div>

      </div>
      <Pagination links={stations.meta.links} />
    </AuthenticatedLayoutSuper>
  )
}

export default Index
