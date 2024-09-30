import AuthenticatedLayoutSuper from "@/Layouts/AuthenticatedLayoutSuper"
import { Head } from "@inertiajs/react"


function Index() {
  return (
    <AuthenticatedLayoutSuper
      header={
        <div className="flex justify-between">
          <h1>Reports</h1>
        </div>
      }
    >
      <Head title="Reports" />
      <div className="py-12">
        <div className="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
          <div className="p-6 text-gray-900 dark:text-gray-100">
            
          </div>
        </div>
      </div>
      
    </AuthenticatedLayoutSuper>
  )
}

export default Index
