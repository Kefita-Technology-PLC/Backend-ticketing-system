
import PrimaryLink from "@/Components/PrimaryLink";
import { useState } from "react";
import { Button } from "@/Components/ui/button";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";

interface Vehicle {
  id: number;
  plate_number: string;
  code: number,
  region: string,
}

interface AlertDeleteProps {
  vehicle: Vehicle;
}

export default function DeleteAlert({ vehicle }: AlertDeleteProps) {
  const [isOpen, setIsOpen] = useState(false);

  const closeDialog = () => {
    setIsOpen(false);
  };

  return (
    <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
      <AlertDialogTrigger asChild>
        <Button variant={"outline"} className="bg-red-600 text-white p-2 text-xs" onClick={() => setIsOpen(true)}>
          Delete
        </Button>
      </AlertDialogTrigger>

      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
          <AlertDialogDescription>
            This action cannot be undone. This will permanently delete <strong>{vehicle.plate_number + " "}</strong>
            vehicle and remove the data from the servers.
          </AlertDialogDescription>
        </AlertDialogHeader>

        <AlertDialogFooter>
          <AlertDialogCancel>
            Cancel
          </AlertDialogCancel>
          <AlertDialogAction>
            <PrimaryLink
              href={route("vehicles-stations.destroy", {
                vehicles_station: vehicle.id,
              })}
              method={"delete"}
              onSuccess={closeDialog} // Close dialog after deletion
            >
              Continue
            </PrimaryLink>
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  );
}
