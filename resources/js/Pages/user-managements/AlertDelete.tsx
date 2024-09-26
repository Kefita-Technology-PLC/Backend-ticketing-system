import PrimaryLink from "@/Components/PrimaryLink"
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/Components/ui/alert-dialog"
import { Button } from "@/Components/ui/button"

interface User{
  id: number,
  name:string,
}

interface AlertDelete{
  user:User
}


export function AlertDelete({user}: AlertDelete) {
  console.log(user)
  return (
    <AlertDialog>
      <AlertDialogTrigger asChild>
        <Button variant={'outline'}>Delete</Button>
      </AlertDialogTrigger>

      <AlertDialogContent>

        <AlertDialogHeader>
          <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
          <AlertDialogDescription>
            This action cannot be undone. This will permanently delete {user.name}
            account and remove your data from the servers.
          </AlertDialogDescription>
        </AlertDialogHeader>

        <AlertDialogFooter>
          <AlertDialogCancel>Cancel</AlertDialogCancel>
          <PrimaryLink className="mt-2"
            href={route('user-managements.destroy',{
              user_management: user.id
            })}
          >Continue</PrimaryLink>
        </AlertDialogFooter>

      </AlertDialogContent>
    </AlertDialog>
  )
}
