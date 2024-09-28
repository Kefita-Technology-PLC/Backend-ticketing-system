import PrimaryLink from "@/Components/PrimaryLink"
import AuthenticatedLayoutSuper from "@/Layouts/AuthenticatedLayoutSuper"
import { Head, router } from "@inertiajs/react"
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/Components/ui/table';
import { ChevronDownIcon, ChevronUpIcon } from "lucide-react";
import TextInput from "@/Components/TextInput";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheckCircle, faTrash } from "@fortawesome/free-solid-svg-icons";
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime';
import Pagination from "@/Components/Pagination";

import { toast } from "sonner";
import EditedChecker from "@/Components/EditedChecker";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";


dayjs.extend(relativeTime)


interface Associations {
  id: number,
  name: string,
  establishment_date: string,
  created_at: string,
  updated_at: string,
  creator?: { name: string },
  updater?: { name: string }
}

interface AssociationResponse {
  data: Associations[],
  links: any,
  meta: { links: any[] }
}

interface IndexProps {
  associations: AssociationResponse,
  queryParams?: any,
  success: string,
}

function Index({ associations, queryParams = {}, success }: IndexProps) {

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
    router.get(route('all-associations.index'), queryParams);
  };

  const sortChanged = (name: string) => {
    if (name === queryParams.sort_field) {
      queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = 'asc';
    }
    router.get(route('all-associations.index'), queryParams);
  };

  const onKeyDown = (name: string, e: any) => {
    if (e.key !== 'Enter') return;
    searchFieldChanged(name, e.target.value);
  };

  return (
    <AuthenticatedLayout
      header={
        <div className="flex justify-between">
          <h1>Associations</h1>
          {/* <CreateAlert /> */}
        </div>
      }
    >
      <Head title="Associations" />
      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
            <Table>
              <TableCaption>A list of Associations</TableCaption>

              {/**Table Header */}
              <TableHeader>
                <TableRow>
                  <TableHead
                    onClick={() => sortChanged('id')}
                    className="text-nowrap"
                  >
                    <div className="flex items-center gap-x-1">
                      #No
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>

                  <TableHead
                    onClick={() => sortChanged('name')}
                  >
                    <div className="flex items-center gap-x-1">
                      Name
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>

                  <TableHead
                    onClick={() => sortChanged('establishment_date')}
                    className=" text-nowrap"
                  >
                    <div className="flex items-center gap-x-1">
                      Establishment Date
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>

                  <TableHead className=" text-nowrap">
                    <div className="flex items-center gap-x-1">
                      Edited
                    </div>
                  </TableHead>

                  <TableHead
                    onClick={() => sortChanged('created_at')}
                    className=" text-nowrap"
                  >
                    <div className="flex items-center gap-x-1">
                      Registration Date
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>

                  <TableHead
                    onClick={() => sortChanged('updated_at')}
                    className=" text-nowrap"
                  >
                    <div className="flex items-center gap-x-1">
                      Updated at
                      <div className=' hover:cursor-pointer'>
                        <ChevronUpIcon className='w-4' />
                        <ChevronDownIcon className='w-4 -mt-3' />
                      </div>
                    </div>
                  </TableHead>

                  <TableHead>
                    <div className="flex items-center gap-x-1 text-nowrap">
                      Created By
                    </div>
                  </TableHead>

                  <TableHead>
                    <div className="flex items-center gap-x-1 text-nowrap">
                      Updated By
                    </div>
                  </TableHead>

                  <TableHead>
                    <div className="felx items-center gap-x-1 text-nowrap">
                      Actions
                    </div>
                  </TableHead>

                </TableRow>
              </TableHeader>

              {/**Table Header for search */}
              <TableHeader>
                <TableRow>
                  <TableHead>
                  </TableHead>

                  <TableHead>
                    <TextInput
                      className="w-full"
                      placeholder="Name"
                      defaultValue={queryParams.name}
                      onBlur={(e) => searchFieldChanged('name', e.target.value)}
                      onKeyDown={(e) => onKeyDown('name', e)}
                    />
                  </TableHead>

                  <TableHead>
                  </TableHead>

                  <TableHead>
                  </TableHead>

                  <TableHead>
                  </TableHead>

                  <TableHead>
                  </TableHead>

                </TableRow>
              </TableHeader>

              <TableBody>
                {associations.data.map((association, index) => (
                  <TableRow key={association.id}>
                    <TableCell className=" text-nowrap">{index + 1}</TableCell>
                    <TableCell className=" text-nowrap">{association.name}</TableCell>
                    <TableCell className=" text-nowrap">
                      <div className="flex flex-col items-center">
                        <span>{new Date(association.establishment_date).toLocaleDateString() }</span>
                        <span>({dayjs(association.establishment_date).fromNow()})</span>
                      </div></TableCell>
                    <TableCell className=' text-nowrap'>
                      <EditedChecker thing={association} />
                    </TableCell>
                    <TableCell className=" text-nowrap">{ dayjs(association.created_at).fromNow()}</TableCell>
                    <TableCell className=" text-nowrap">{dayjs(association.updated_at).fromNow()}</TableCell>
                    <TableCell className=" text-nowrap">{association.creator?.name}</TableCell>
                    <TableCell className=" text-nowrap">{association.updater?.name}</TableCell>
                    <TableCell>
                      <div className="flex items-center gap-x-2">
                        {/* <EditDialog association={association} />
                        <DeleteDialog association={association} /> */}
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        </div>
      </div>
      <Pagination links={associations.meta.links} />
    </AuthenticatedLayout>
  )
}

export default Index
