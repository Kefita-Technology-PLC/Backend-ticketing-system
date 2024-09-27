import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/react";
import { FormEventHandler, useState } from "react";

interface Station{
  id: number,
  name: string,
  location: string,
}

interface AlertUpdateProps{
  station: Station
}

function UpdateAlert({station}: AlertUpdateProps) {
  const [isOpen, setIsOpen] = useState(false);

  const closeDialog = () => {
    setIsOpen(false);
  };

  const {data, setData, put, processing, errors, reset} = useForm({
    name: station.name,
    location: station.location,
  })

  const submit: FormEventHandler = (e)=>{
    e.preventDefault()
    put(route('all-stations.update', station.id),{
      onSuccess:()=>{
        closeDialog()
      },
      onError:(e)=>{
        console.log('Validation errors: ', e)
      }
    })
  }

  return (
    <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
      <AlertDialogTrigger asChild>
        <Button variant={"outline"} className="text-xs" onClick={() => setIsOpen(true)}>
          Update
        </Button>
      </AlertDialogTrigger>

      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Update a Station</AlertDialogTitle>
          <AlertDialogDescription>
            Fill all the data required
          </AlertDialogDescription>
        </AlertDialogHeader>

        <div className=" flex justify-center items-center">
          <form onSubmit={submit}>
            <div className="mb-4">
              <InputLabel 
                htmlFor='name'
                value='Station Name'
              />
              <TextInput 
                id="name"
                name="name"
                value={data.name}
                onChange={(e)=> setData('name', e.target.value)}
                required
              />

              <InputError message={errors.name}  className="mt-2"/>
            </div>

            <div className="mb-4">

              <InputLabel 
                htmlFor='location'
                value='Station Location'
              />

              <TextInput 
                id="location"
                name="location"
                value={data.location}
                onChange={(e)=> setData('location', e.target.value)}
                required
              />

              <InputError message={errors.location}  className="mt-2"/>
            </div>

            <div className="mt-6 flex gap-x-2">
              <AlertDialogCancel>
                Cancel
              </AlertDialogCancel>

              <AlertDialogAction>
                <PrimaryButton
                  type="submit"
                // Close dialog after deletion
                >
                  Update
                </PrimaryButton>
              </AlertDialogAction>

            </div>
          </form>
        </div>
 
      </AlertDialogContent>
    </AlertDialog>
  )
}

export default UpdateAlert
