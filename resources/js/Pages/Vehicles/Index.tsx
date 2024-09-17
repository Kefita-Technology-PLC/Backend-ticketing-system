import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head } from '@inertiajs/react'

function Index() {
  return (
    <AuthenticatedLayout>
        <Head title='Vehicles' />
    </AuthenticatedLayout>
  )
}

export default Index
