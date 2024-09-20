import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper'
import { faEdit, faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { Head } from '@inertiajs/react'
import { DeleteIcon, EditIcon, Trash } from 'lucide-react'



function Index({users}:{users:any}) {
    console.log(users)
  return (
    <AuthenticatedLayoutSuper
        header={'Users'}
    >
        <Head title='user management' />

        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">
                        {JSON.stringify(users)}

                      <Table>
                        <TableCaption>A list of admin users</TableCaption>
                        <TableHeader>

                          <TableRow>
                            <TableHead className=''>#No</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Phone No</TableHead>
                            <TableHead className=''>Registration Date</TableHead>
                            <TableHead>Privillages</TableHead>
                            <TableHead>Actions</TableHead>
                          </TableRow>

                        </TableHeader>

                        <TableBody>
                          {users.map((user:any,index:number)=>(
                            <TableRow key={index}>
                              <TableCell className=' font-medium'>
                                {index+1}
                              </TableCell>
                              <TableCell>
                                {user.name}
                              </TableCell>
                              <TableCell>
                                {user.email}
                              </TableCell>
                              <TableCell>
                                {user.phone_no}
                              </TableCell>
                              <TableCell>
                                {new Date(user.created_at).toLocaleDateString() }
                              </TableCell>
                              <TableCell>
                                {}
                              </TableCell>
                              <TableCell className='flex gap-x-3'>
                                <FontAwesomeIcon className=' text-red-500' icon={faTrash} />
                                <FontAwesomeIcon className='text-blue-500' icon={faEdit} />
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
