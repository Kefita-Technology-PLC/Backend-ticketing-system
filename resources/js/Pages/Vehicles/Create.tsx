import { FormEventHandler, useEffect, useState } from 'react'
import { Head, useForm } from '@inertiajs/react'
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper'
import InputLabel from '@/Components/InputLabel'
import TextInput from '@/Components/TextInput'
import InputError from '@/Components/InputError'
import SelectInput from '@/Components/SelectInput'
import { SelectGroup, SelectItem, SelectLabel } from '@/Components/ui/select'
import PrimaryButton from '@/Components/PrimaryButton'

interface Station {
  id: string
  name: string
}

interface Association {
  id: string
  name: string
}

function Create() {
  const [stations, setStations] = useState<Station[]>([])
  const [associations, setAssociations] = useState<Association[]>([])
  const [stationQuery, setStationQuery] = useState('')
  const [associationQuery, setAssociationQuery] = useState('')
  const [origin, setOrigin] = useState('')

  const { data, setData, post, processing, errors, reset } = useForm({
    station_id: '',
    association_id: '',
    plate_number: '',
    code: '',
    level: '',
    number_of_passengers: '',
    car_type: '',
    region: '',
    origin: '',
    destination: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    console.log('submitting data:', data)

    post(route('vehicles.store'),{
      onSuccess: ()=>{
        // toast('A vehicle has been created')
      },
      onError: (errors)=>{
        console.log('Validation errors:', errors)
      }
    })
  }

  const fetchStations = async (query: string) => {
    try {
      const response = await fetch(`/api/v1/stations-search?q=${query}`)
      const data = await response.json()
      setStations(Array.isArray(data) ? data : [])
    } catch (error) {
      console.error('Error fetching stations:', error)
      setStations([])
    }
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

  useEffect(() => {
    if (stationQuery.length > 0) {
      fetchStations(stationQuery)
    }
  }, [stationQuery])

  useEffect(() => {
    if (associationQuery.length > 0) {
      fetchAssociations(associationQuery)
    }
  }, [associationQuery])

  return (
    <AuthenticatedLayoutSuper
      header={
        <div className='flex justify-between'>
          <h1>Add Vehicles</h1>
          {/* <PrimaryLink href={route('vehicles.create')}>
            Add More
          </PrimaryLink> */}
        </div>
      }
    >
      <Head title='Add Vehicles' />
      <div className='py-12'>
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <form onSubmit={submit}>
              {/* Station Name Dropdown */}

              <div className='flex gap-x-20 justify-center'>
                <div>
                  <div className='mb-4'>
                    <InputLabel
                      htmlFor='station_id'
                      value='Station Name'
                      className='block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1'
                    />
                    <div className="relative">
                      <input
                        type="text"
                        id="station_id"
                        placeholder="Search station..."
                        className="w-full px-3 py-2 text-sm rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600"
                        value={stationQuery}
                        onChange={(e) => setStationQuery(e.target.value)}
                        required
                      />
                      {stationQuery && stations.length > 0 && (
                        <div className="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                          {stations.slice(0, 10).map((station) => (
                            <div
                              key={station.id}
                              className="px-3 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer"
                              onClick={() => {
                                setData('station_id', station.id)
                                setStationQuery(station.name)
                                setStations([])
                                setOrigin(station.name)
                              }}
                            >
                              {station.name}
                            </div>
                          ))}
                        </div>
                      )}
                    </div>

                    <InputError message={errors.station_id} className='mt-2' />
                  </div>

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
                              className="px-3 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer"
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

                  {/**Palte Number */}
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

                {/**Second Column */}
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
                      value={origin}
                      onChange={(e)=> {
                        setData('origin', e.target.value)
                        setOrigin(e.target.value)
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
            
              <div className='mt-6'>
                <PrimaryButton 
                type='submit' className='ms-4' disabled={processing}
                >
                    Add Vehicle
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayoutSuper>
  )
}

export default Create
