import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/react";
import { FormEventHandler, useState } from "react";

interface Association{
  id: number,
  name: string,
  establishment_date: string,
}

interface AlertUpdateProps{
  association: Association
}

function EditDialog({association}: AlertUpdateProps) {
  const [isOpen, setIsOpen] = useState(false);

  const closeDialog = () => {
    setIsOpen(false);
  };

  const {data, setData, put, processing, errors, reset} = useForm({
    name: association.name,
    establishment_date: association.establishment_date,
  })

  const submit: FormEventHandler = (e)=>{
    e.preventDefault()
    put(route('associations-stations.update', association.id),{
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
          <AlertDialogTitle>Update an Association</AlertDialogTitle>
          <AlertDialogDescription>
            Fill all the data required
          </AlertDialogDescription>
        </AlertDialogHeader>

        <div className=" flex justify-center items-center">
          <form onSubmit={submit}>
            <div className="mb-4">
              <InputLabel 
                htmlFor='name'
                value='Station Name*'
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
                htmlFor='establishment_date'
                value='Establishement Date*'
              />
              <TextInput 
                id="establishment_date"
                name="establishment_date"
                value={data.establishment_date}
                onChange={(e)=> setData('establishment_date', e.target.value)}
                type="date"
                required
              />

              <InputError message={errors.establishment_date}  className="mt-2"/>
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

export default EditDialog
