import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import SelectInput from "@/Components/SelectInput";
import TextInput from "@/Components/TextInput";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/Components/ui/alert-dialog";
import { Button } from "@/Components/ui/button";
import { SelectGroup, SelectItem, SelectLabel } from "@/Components/ui/select";
import { useForm } from "@inertiajs/react";
import { FormEventHandler, useEffect, useState } from "react";


interface Vehicle {
  id: number;
  code: number;
  region: string;
  station_id: number,
  plate_number: string;
  level: string;
  car_type: string;
  association_id: number;
  origin: string;
  destination: string;
  number_of_passengers: string;
}

interface Association {
  id: string
  name: string
}

interface EditProps {
  vehicle: Vehicle;
}

function EditAlert({vehicle}: EditProps) {
  const [isOpen, setIsOpen] = useState(false);
  const [associationQuery, setAssociationQuery] = useState('')
  const [associations, setAssociations] = useState<Association[]>([])
  // const [origin, setOrigin] = useState('')

  const closeDialog = () => {
    setIsOpen(false);
  };


  const { data, setData, put, processing, errors } = useForm({
    station_id: vehicle.station_id.toString(),
    association_id: vehicle.association_id.toString(),
    plate_number: vehicle.plate_number,
    code: vehicle.code.toString(),
    level: vehicle.level,
    number_of_passengers: vehicle.number_of_passengers.toString(),
    car_type: vehicle.car_type,
    region: vehicle.region,
    origin: vehicle.origin,
    destination: vehicle.destination
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    // console.log('submitting data:', data)

    put(route('vehicles-stations.update', vehicle.id), {
      onSuccess: () => {
        setIsOpen(false)
        // toast('Vehicle has been updated')
      },
      onError: (errors) => {
        console.log('Validation errors:', errors)
      }
    })
  }

  const fetchAssociations = async (query: string) => {
    try {
      const response = await fetch(`/api/v1/associations-search?q=${query}`)
      const data = await response.json()
      setAssociations(Array.isArray(data) ? data : [])
    } catch (error) {
      console.error('Error fetching associations:', error)
      setAssociations([])
    }
  }

  const fetchAssociationName = async (id: string) => {
    try {
      const response = await fetch(`/v1/associations/${id}`)
      const data = await response.json()
      // console.log(data)
      setAssociationQuery(data.data.name)
    } catch (error) {
      console.error('Error fetching association name:', error)
    }
  }


  useEffect(() => {
    fetchAssociationName(data.association_id)
  }, [])

  useEffect(() => {
    if (associationQuery.length > 0) {
      fetchAssociations(associationQuery)
    }
  }, [associationQuery])

  return (
    <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
      <AlertDialogTrigger asChild>
        <Button variant={"outline"} className="text-xs" onClick={() => setIsOpen(true)}>
          Edit
        </Button>
      </AlertDialogTrigger>

      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Update a Vehicle</AlertDialogTitle>
          <AlertDialogDescription>
            Fill all the data required
          </AlertDialogDescription>
        </AlertDialogHeader>

        <div className=" flex justify-center items-center">
        <form onSubmit={submit}>
              <div className='flex gap-x-20 justify-center'>
                <div>
                  {/* Station Name Dropdown */}

                  {/* Association Name Dropdown */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='association_id' 
                      value='Association Name'
                      className='block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1'
                    />
                    <div className="relative">
                      <input
                        type="text"
                        id="association_id"
                        placeholder="Search association..."
                        className="w-full px-3 py-2 text-sm rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600"
                        value={associationQuery}
                        onChange={(e) => setAssociationQuery(e.target.value)}
                        required
                      />
                      {associationQuery && associations.length > 0 && (
                        <div className="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                          {associations.slice(0, 10).map((association) => (
                            <div
                              key={association.id}
                              className="px-3 py-2 text-sm"
                              onClick={() => {
                                setData('association_id', association.id)
                                setAssociationQuery(association.name)
                                setAssociations([])
                              }}
                            >
                              {association.name}
                            </div>
                          ))}
                        </div>
                      )}
                    </div>
                    <InputError message={errors.association_id} className='mt-2' />
                  </div>

                  {/** Plate Number */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='plate_number'
                      value='Plate Number'
                    />

                    <TextInput 
                      id='plate_number'
                      name='plate_number'
                      value={data.plate_number}
                      onChange={(e)=> setData('plate_number', e.target.value)}
                      required
                    />
                    
                    <InputError message={errors.plate_number} className='mt-2' />
                  </div>

                  {/**Level */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='level'
                      value='Level'
                    />

                    <SelectInput 
                      value={data.level}
                      onChange={(e)=> setData('level', e)}
                    >
                      <SelectGroup>
                        <SelectLabel>Levels</SelectLabel>
                        <SelectItem value="level_1">Level 1</SelectItem>
                        <SelectItem value="level_2">Level 2</SelectItem>
                        <SelectItem value="level_3">Level 3</SelectItem>
                        <SelectItem value="level_4">Level 4</SelectItem>
                      </SelectGroup>
                    </SelectInput>
                    
                    <InputError message={errors.level} className='mt-2' />
                  </div>

                  {/**Code */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='code'
                      value='Code'
                    />

                    <SelectInput 
                      value={data.code}
                      onChange={(e)=> setData('code', e)}
                    >
                      <SelectGroup>
                        <SelectLabel>Codes</SelectLabel>
                        <SelectItem value="1">Code 1</SelectItem>
                        <SelectItem value="2">Code 2</SelectItem>
                        <SelectItem value="3">Code 3</SelectItem>
                      </SelectGroup>
                    </SelectInput>
                    
                    <InputError message={errors.code} className='mt-2' />
                  </div>

                </div>

                {/* Second column */}
                <div>
                  {/**Passengers Capcity */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='number_of_passengers'
                      value='Passengers Capacity'
                    />

                    <SelectInput 
                      value={data.number_of_passengers}
                      onChange={(e)=> setData('number_of_passengers', e)}
                    >
                      <SelectGroup>
                        <SelectLabel>Levels</SelectLabel>
                        <SelectItem value="4">4 Passengers</SelectItem>
                        <SelectItem value="12">12 Passengers</SelectItem>
                        <SelectItem value="20">20 Passengers</SelectItem>
                        <SelectItem value="24">24 Passengers</SelectItem>
                        <SelectItem value="70">70 Passengers</SelectItem>
                      </SelectGroup>
                    </SelectInput>
                    
                    <InputError message={errors.number_of_passengers} className='mt-2' />
                  </div>

                  {/**Car Type */}
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='car_type'
                      value='Car Type'
                    />

                    <SelectInput 
                      value={data.car_type}
                      onChange={(e)=> setData('car_type', e)}
                    >
                      <SelectGroup>
                        <SelectLabel>Car Type</SelectLabel>
                        <SelectItem value="bus">Bus</SelectItem>
                        <SelectItem value="mini_bus">Mini Bus</SelectItem>
                        <SelectItem value="higer">Higer</SelectItem>
                        <SelectItem value="lonchin">Lonchin</SelectItem>
                      </SelectGroup>
                    </SelectInput>
                    
                    <InputError message={errors.car_type} className='mt-2' />
                  </div>
                    
                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='region'
                      value='Region'
                    />

                    <SelectInput 
                      value={data.region}
                      onChange={(e)=> setData('region', e)}
                    >
                      <SelectGroup>
                        <SelectLabel>Select Region</SelectLabel>
                        <SelectItem value="TG">Tigray</SelectItem>
                        <SelectItem value="AF">Afar</SelectItem>
                        <SelectItem value="AA">Addis Ababa</SelectItem>
                        <SelectItem value="SN">Southern People's</SelectItem>
                        <SelectItem value="DR">Dire Dawa</SelectItem>
                        <SelectItem value="SD">Sidama</SelectItem>
                        <SelectItem value="AM">Amhara</SelectItem>
                        <SelectItem value="OR" >Oromia</SelectItem>
                        <SelectItem value="SM">Somalia</SelectItem>
                        <SelectItem value="BN">Benishalgul Gumuz</SelectItem>
                        <SelectItem value="HR">Harari</SelectItem>
                        <SelectItem value="SW">Southern Western</SelectItem>
                        <SelectItem value="ET">Ethiopia</SelectItem>
                      </SelectGroup>
                    </SelectInput>
                    
                    <InputError message={errors.region} className='mt-2' />
                  </div>

                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='origin'
                      value='Deployment Origin'
                    />

                    <TextInput 
                      id='origin'
                      name='origin'
                      value={data.origin}
                      onChange={(e)=> {
                        setData('origin', e.target.value)
                        // setOrigin(e.target.value)
                      }}
                      required
                    />
                    
                    <InputError message={errors.origin} className='mt-2' />
                  </div>

                  <div className='mb-4'>
                    <InputLabel 
                      htmlFor='destination'
                      value='Deployment Destination'
                    />

                    <TextInput 
                      id='destination'
                      name='destination'
                      value={data.destination}
                      onChange={(e)=> setData('destination', e.target.value)}
                      required
                    />
                    
                    <InputError message={errors.destination} className='mt-2' />
                  </div>
                </div>

              </div>

              {/* Submit */}
              <div className='mt-6'>
                <AlertDialogFooter>
                  <PrimaryButton className='ms-4' type='submit' disabled={processing} onClick={closeDialog}>
                    Update Vehicle
                  </PrimaryButton>
                  <AlertDialogCancel>
                    Cancel
                  </AlertDialogCancel>
                </AlertDialogFooter>
              </div>
            </form>
        </div>

      </AlertDialogContent>
    </AlertDialog>
  )
}

export default EditAlert
