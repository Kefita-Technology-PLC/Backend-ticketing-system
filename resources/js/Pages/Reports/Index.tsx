import { Button } from "@/Components/ui/button";
import AuthenticatedLayoutSuper from "@/Layouts/AuthenticatedLayoutSuper";
import { Head } from "@inertiajs/react";
// Ensure this import matches your setup
import axios from "axios";

function Index() {
    const handleExportCsv = async () => {
        const response = await axios.get('/export/csv', {
            responseType: 'blob', // Important for downloading files
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'tickets.csv'); // Filename to download
        document.body.appendChild(link);
        link.click();
        link.remove();
    };

    const handleExportExcel = async () => {
        const response = await axios.get('/export/excel', {
            responseType: 'blob', // Important for downloading files
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'tickets.xlsx'); // Filename to download
        document.body.appendChild(link);
        link.click();
        link.remove();
    };

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
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className=" overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
                      <div className="p-6 text-gray-900 dark:text-gray-100">
                      <h2 className="text-lg font-semibold mb-4">Export Reports</h2>
                        <div className="flex space-x-4">
                            <Button onClick={handleExportCsv}>
                                Export as CSV
                            </Button>
                            <Button onClick={handleExportExcel}>
                                Export as Excel
                            </Button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayoutSuper>
    );
}

export default Index;
