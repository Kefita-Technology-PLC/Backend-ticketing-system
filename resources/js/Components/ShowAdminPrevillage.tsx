import { Link } from "@inertiajs/react";
import { Button } from "./ui/button";
import { Checkbox } from "./ui/checkbox";
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from "./ui/dialog";
import { allPermissions } from "@/constants/allPermissions";
import PrimaryLink from "./PrimaryLink";

// Define the User interface
interface User {
  id: number;
  name: string;
  permissions: string[];
}

// Define the props interface for ShowAdminPrevillage
interface ShowPrevillageProps {
  user: User;
}

function ShowAdminPrevillage({ user }: ShowPrevillageProps) {
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button variant={'outline'}>
          Show 
        </Button>
      </DialogTrigger>

      <DialogContent>
        <DialogHeader>
          <DialogTitle>Privileges</DialogTitle>
          <DialogDescription >Here are the Privileges for <strong className="font-bold text-black dark:text-white">{user.name}</strong>:</DialogDescription>
        </DialogHeader>

        <div className="mt-4">
          <div>
            {/* Iterate through all permissions */}
            {allPermissions.map((permissionObj, index) => {
              // Check if the user's permissions include the current permission
              const isChecked = user.permissions.includes(permissionObj.name);

              return (
                <div key={index} className="flex gap-x-4 px-3 items-center">
                  {/* Display the checkbox, checked or unchecked based on user's permissions */}
                  <Checkbox checked={isChecked} disabled className="cursor-not-allowed" />
                  <label>{'Can ' + permissionObj.name}</label>
                </div>
              );
            })}
          </div>
          {/* Link to the Edit page */}
          <PrimaryLink className="mt-2" href={route('user-managements.edit', { user_management: user.id })} method="get">
            Edit
          </PrimaryLink>
        </div>
      </DialogContent>
    </Dialog>
  );
}

export default ShowAdminPrevillage;
