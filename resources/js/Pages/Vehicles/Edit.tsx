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

interface Vehicle {
  id: number;
  code: number;
  region: string;
  plate_number: string;
  level: string;
  car_type: string;
  station_id: number;
  association_id: number;
  origin: string;
  destination: string;
  number_of_passengers: string;
}

interface EditProps {
  vehicle: Vehicle;
}

function Edit({ vehicle }: EditProps) {
  const [stations, setStations] = useState<Station[]>([])
  const [associations, setAssociations] = useState<Association[]>([])
  const [stationQuery, setStationQuery] = useState('')
  const [associationQuery, setAssociationQuery] = useState('')

  const { data, setData, put, processing, errors } = useForm({
    station_id: vehicle.station_id.toString(),
    association_id: vehicle.association_id.toString(),
    plate_number: vehicle.plate_number,
    code: vehicle.code.toString(),
    level: vehicle.level,
    number_of_passengers: vehicle.number_of_passengers,
    car_type: vehicle.car_type,
    region: vehicle.region,
    origin: vehicle.origin,
    destination: vehicle.destination
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    console.log('submitting data:', data)

    put(route('vehicles.update', vehicle.id), {
      onSuccess: () => {
        // toast('Vehicle has been updated')
      },
      onError: (errors) => {
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

  const fetchStationName = async (id: string) => {
    try {
      const response = await fetch(`/v1/stations/${id}`)
      const data = await response.json()
      console.log(data)
      setStationQuery(data.data.name)
    } catch (error) {
      console.error('Error fetching station name:', error)
    }
  }

  const fetchAssociationName = async (id: string) => {
    try {
      const response = await fetch(`/v1/associations/${id}`)
      const data = await response.json()
      console.log(data)
      setAssociationQuery(data.data.name)
    } catch (error) {
      console.error('Error fetching association name:', error)
    }
  }

  useEffect(() => {
    fetchStationName(data.station_id)
    fetchAssociationName(data.association_id)
  }, [])

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
          <h1>Edit Vehicle</h1>
        </div>
      }
    >
      <Head title='Edit Vehicle' />
      <div className='py-12'>
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <form onSubmit={submit}>
              <div className='flex gap-x-20 justify-center'>
                <div>
                  {/* Station Name Dropdown */}
                  <div className='mb-4'>
                    <InputLabel
                      htmlFor='station_id'
                      value='Station Name'
                    />
                    <div className="relative">
                      <input
                        type="text"
                        id="station_id"
                        placeholder="Search station..."
                        className="w-full px-3 py-2 text-sm"
                        value={stationQuery}
                        onChange={(e) => setStationQuery(e.target.value)}
                        required
                      />
                      {stationQuery && stations.length > 0 && (
                        <div className="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                          {stations.slice(0, 10).map((station) => (
                            <div
                              key={station.id}
                              className="px-3 py-2 text-sm"
                              onClick={() => {
                                setData('station_id', station.id)
                                setStationQuery(station.name)
                                setStations([])
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

                  {/* Association Name Dropdown */}
                  <div className='mb-4'>
                    <InputLabel htmlFor='association_id' value='Association Name' />
                    <div className="relative">
                      <input
                        type="text"
                        id="association_id"
                        placeholder="Search association..."
                        className="w-full px-3 py-2 text-sm"
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

                  {/* Other fields remain the same */}
                  {/* ... */}

                </div>

                {/* Second column remains the same */}
                {/* ... */}

              </div>

              {/* Submit */}
              <div className='flex justify-center'>
                <PrimaryButton className='w-full py-4' disabled={processing}>
                  Update Vehicle
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayoutSuper>
  )
}

export default Edit