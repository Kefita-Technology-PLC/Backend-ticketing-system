import PrimaryLink from "@/Components/PrimaryLink"
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from "@/Components/ui/dialog";
import { Button } from "@/Components/ui/button"
import { Link } from "@inertiajs/react"

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
    <Dialog>
      <DialogTrigger asChild>
        <Button variant={'outline'} className=" bg-red-600 text-white p-2">Delete</Button>
      </DialogTrigger>

      <DialogContent>

        <DialogHeader>
          <DialogTitle>Are you absolutely sure?</DialogTitle>
          <DialogDescription>
            This action cannot be undone. This will permanently delete <strong>{user.name+' '}</strong>  
            account and remove your data from the servers.
          </DialogDescription>
        </DialogHeader>

        <DialogFooter>
          
            <PrimaryLink
              href={route('user-managements.destroy',{
                user_management: user.id
              })}
              method={"delete"}
            >Continue</PrimaryLink>
         
        </DialogFooter>

      </DialogContent>
    </Dialog>
  )
}
