import Dropdown from '@/Components/Dropdown'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper'
import { Head, router } from '@inertiajs/react'
import { ChevronDownIcon, ChevronUpIcon } from 'lucide-react'
import dayjs from 'dayjs'
import realativeTime from 'dayjs/plugin/relativeTime'
import PrimaryLink from '@/Components/PrimaryLink'
import ShowAdminPrevillage from '@/Components/ShowAdminPrevillage'
import { AlertDelete } from './AlertDelete'

dayjs.extend(realativeTime)

interface user{
  id: number,
  name: string,
  phone_no: string,
  email: string,
  gender: string,
  salary: string,
  station_id: number
  created_at: string,
  updated_at: string,
  station?: {name: string}
  creator?: {name: string},
  updater?: {name: string},
  permissions: string[]
}

interface UsersResponse{
  data: user[]
  links: any
  meta: {links: any[]}
}

interface IndexProps{
  users: UsersResponse,
  queryParams?: any,
  success: string,
}


function Index({users, queryParams={}, success}: IndexProps) {
  queryParams = queryParams || {}

  // console.log(users)
  const searchFieldChanged = (name: string, value: any) => {
    if (value) {
      queryParams[name] = value;
    } else {
      delete queryParams[name];
    }
    router.get(route('user-managements.index'), queryParams);
  };

  const sortChanged = (name: string) => {
    if (name === queryParams.sort_field) {
      queryParams.sort_direction = queryParams.sort_direction === 'asc' ? 'desc' : 'asc';
    } else {
      queryParams.sort_field = name;
      queryParams.sort_direction = 'asc';
    }
    router.get(route('user-managements.index'), queryParams);
  };

  return (
    <AuthenticatedLayoutSuper
        header={
          <div className='flex justify-between'>
            <h1 className=' font-bold'>Vehicles</h1>
            <PrimaryLink href={route('user-managements.create')}>Add Users</PrimaryLink>
        </div>
        }
    >
      <Head title='user management' />
      
      <div className="py-12">
        <div className="max-w-8xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-900">
            <div className="p-6 text-gray-900 dark:text-gray-100">
            

              <Table>
                <TableCaption>A list of admin users</TableCaption>
                <TableHeader>

                  <TableRow>
                    <TableHead onClick={() => sortChanged('id')} className='text-nowrap'>
                      <div className='flex items-center gap-x-1'>
                        #No
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead onClick={()=> sortChanged('name')}>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Name</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead >
                    <TableHead onClick={()=> sortChanged('gender')} className='text-nowrap'>
                    <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Gender</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead onClick={()=> sortChanged('email')} className=' text-nowrap'>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Email</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead onClick={()=> sortChanged('phone_no')} className='text-nowrap'>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Phone Number</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead className=' text-nowrap'>Station</TableHead>
                    <TableHead onClick={()=> sortChanged('salary')} className='text-nowrap'>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Salary</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead onClick={()=> sortChanged('create_at')} className=' text-nowrap'>
                      <div className='flex items-center gap-x-1'>
                        <span className='text-nowrap'>Registration Date</span>
                        <div className=' hover:cursor-pointer'>
                          <ChevronUpIcon className='w-4' />
                          <ChevronDownIcon className='w-4 -mt-3' />
                        </div>
                      </div>
                    </TableHead>
                    <TableHead className='text-nowrap'>Privillages</TableHead>
                    <TableHead className='text-nowrap'>Creator</TableHead>
                    <TableHead className='text-nowrap'>Updater</TableHead>
                    <TableHead className='text-nowrap'>Actions</TableHead>
                  </TableRow>

                </TableHeader>

                <TableBody>
                  {users.data.map((user,index)=>(
                    <TableRow key={index}>
                      <TableCell className=' text-nowrap'>
                        {index+1}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.name}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.gender || 'N/A'}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.email}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.phone_no}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.station?.name || 'N/A'}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.salary || 'N/A'}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {dayjs(user.created_at).fromNow() || 'N/A'}
                      </TableCell>
                      <TableCell className='text-nowrap'>
                        {<>
                        <ShowAdminPrevillage 
                          user={user}
                        />
                        </>}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.creator?.name || 'N/A'}
                      </TableCell>
                      <TableCell className=' text-nowrap'>
                        {user.updater?.name || 'N/A'}
                      </TableCell>
                      <TableCell className='flex gap-x-3'>
                        <Dropdown>
                          <Dropdown.Trigger>
                          <button>
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                          </button>
                          </Dropdown.Trigger>

                          <Dropdown.Content >
                            <Dropdown.Link
                              as='button'
                              href={route('user-managements.edit', user.id)} 
                              method='get'
                            >
                              Edit
                            </Dropdown.Link>
                            {/* <Dropdown.Link as='button' href={route('user-managements.destroy',user.id )} method="delete">
                              Delete
                            </Dropdown.Link> */}
                            <AlertDelete user={user} />
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

    </AuthenticatedLayoutSuper>
  )
}

export default Index
