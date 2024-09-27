import PrimaryLink from "@/Components/PrimaryLink";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";
import { Button } from "@/Components/ui/button";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useState } from "react";

interface Station{
  id: number,
  name: string,
  location: string,
}

interface AlertDeleteProps{
  station: Station
}

function DeleteAlert({station}: AlertDeleteProps) {
  const [isOpen, setIsOpen] = useState(false);

  const closeDialog = () => {
    setIsOpen(false);
  };
  return (
    <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
      <AlertDialogTrigger asChild>
        <Button variant={"outline"} className="text-xs text-red-500" onClick={() => setIsOpen(true)}>
          <FontAwesomeIcon 
            icon={faTrash}
          />
        </Button>
      </AlertDialogTrigger>

      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
          <AlertDialogDescription>
            This action cannot be undone. This will permanently delete <strong>{station.name + " "}</strong>
            station and remove the data from the servers.
          </AlertDialogDescription>
        </AlertDialogHeader>

        <AlertDialogFooter>
          <AlertDialogCancel>
            Cancel
          </AlertDialogCancel>
          <AlertDialogAction>
            <PrimaryLink
              href={route("all-stations.destroy", {
                all_station: station.id,
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
  )
}

export default DeleteAlert
