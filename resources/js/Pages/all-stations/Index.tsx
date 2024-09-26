import PrimaryLink from "@/Components/PrimaryLink"
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

interface Station{
  id: number,
  name: string,
  location: string,
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
    router.get(route('vehicles.index'), queryParams);
  };

  return (
    <AuthenticatedLayoutSuper header={
      <div className='flex justify-between'>
      <h1>Station</h1>
        <PrimaryLink href={route('all-stations.create')}>Add Station</PrimaryLink>
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
                  <TableHead onClick={()=> sortChanged('id')}></TableHead>
                </TableRow>

              </TableHeader>
            </Table>
          </div>

        </div>

      </div>
      
    </AuthenticatedLayoutSuper>
  )
}

export default Index
