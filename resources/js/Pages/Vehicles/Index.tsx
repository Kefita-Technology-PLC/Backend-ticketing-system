import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head } from '@inertiajs/react'

function Index({vehicles}:{vehicles: any}) {
    console.log(vehicles)
  return (
    <AuthenticatedLayout
        header={'Vehicles'}
    >
        <Head title='Vehicles' />

        <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {JSON.stringify(vehicles, undefined,2)}
                        </div>
                    </div>
                </div>
            </div>

    </AuthenticatedLayout>
  )
}

export default Index
