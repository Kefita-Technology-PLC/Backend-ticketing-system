import { FormEventHandler, useState } from "react";
import { Button } from "@/Components/ui/button";
import { useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";


export default function CreateAlert() {
  const [isOpen, setIsOpen] = useState(false);

  const closeDialog = () => {
    setIsOpen(false);
  };

  const {data, setData, post, processing, errors, reset} = useForm({
    name: '',
    establishment_date: '',
  })

  const submit: FormEventHandler = (e) =>{
    e.preventDefault()
    post(route('associations-staions.store'),{
      onSuccess: ()=>{
        // toast('A vehicle has been created')
        closeDialog()
      },
      onError: (errors)=>{
        console.log('Validation errors:', errors)
      }
    })
  }

  return (
    <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
      <AlertDialogTrigger asChild>
        <Button variant={"outline"} className="p-2 text-xs" onClick={() => setIsOpen(true)}>
          Create Associations
        </Button>
      </AlertDialogTrigger>

      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Create an Assocaiton</AlertDialogTitle>
          <AlertDialogDescription>
            Fill all the data required
          </AlertDialogDescription>
        </AlertDialogHeader>

        <div className=" flex justify-center items-center">
          <form onSubmit={submit}>
            <div className="mb-4">
              <InputLabel 
                htmlFor='name'
                value='Associations Name'
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
                  Add Station
                </PrimaryButton>
              </AlertDialogAction>

            </div>
          </form>
        </div>
 
      </AlertDialogContent>
    </AlertDialog>
  );
}
