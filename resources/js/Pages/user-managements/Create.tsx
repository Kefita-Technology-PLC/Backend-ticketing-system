import FormInput from '@/Components/FormInput';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper'
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler, useEffect, useState } from 'react'
import { usePage } from '@inertiajs/react';
import { Eye } from 'lucide-react';
import { EyeClosedIcon } from '@radix-ui/react-icons';

interface Station {
  id: string;
  name: string;
}

function Create() {
  const [showPassword, setShowPassword] = useState(false)
  const [showPassword2, setShowPassword2] = useState(false)
  const [stations, setStations] = useState<Station[]>([])
  const [stationQuery, setStationQuery] = useState('')
  const {data, setData, post, processing, errors, reset} = useForm({
    name: '',
    phone_no: '+251',
    email: '',
    gender: '',
    salary: '',
    station_id: '',
    password: '',
    password_confirmation: '',
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('user-managements.store'), {
      onError: (e) => {
        console.log('Validation errors:', errors);
      }
    })
  }

  const fetchStations = async (query: string) => {
    try {
      const response = await fetch(`/api/v1/stations-search?q=${query}`);
      const data = await response.json();
      setStations(Array.isArray(data) ? data : []);
    } catch (error) {
      console.error('Error fetching stations:', error);
      setStations([]);
    }
  }

  useEffect(() => {
    if (stationQuery.length > 0) {
      fetchStations(stationQuery);
    }
  }, [stationQuery])


  const togglePasswordVisibility = () => {
    setShowPassword(!showPassword);
  }

  const togglePasswordVisibility2 = () => {
      setShowPassword2(!showPassword2);
  }
  return (
    <AuthenticatedLayoutSuper
      header={
        <div>
          <h1>Add Users</h1>
        </div>
      }
    >
      <Head title="user add" />
      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="p-6 bg-white dark:bg-gray-800 rounded-lg shadwon-sm">
            <form onSubmit={submit}>

              <div className='flex justify-center gap-x-20 flex-col sm:flex-row'>
                {/**First Column */}
                <div>
                  {/* Admin name */}
                  <FormInput 
                    labelName={'Admin Name'}
                    htmlFor={'name'}
                    name={'name'}
                    errorMessage={errors.name}
                    onChange={(e: any) => setData('name', e.target.value)}
                    value={data.name}
                    placeholder="Jon Doe"
                    type="text"
                  />

                  {/* Admin Phone Number */}
                  <FormInput 
                    labelName={'Admin Phone Number'}
                    htmlFor={'phone_no'}
                    name={'phone_no'}
                    errorMessage={errors.phone_no}
                    onChange={(e: any) => setData('phone_no', e.target.value)}
                    value={data.phone_no}
                    placeholder="+251xxxxxxxxx"
                    type="text"
                  />

                  {/* Admin Email */}
                  <FormInput 
                    labelName={'Admin Email'}
                    htmlFor={'email'}
                    name={'email'}
                    errorMessage={errors.email}
                    onChange={(e: any) => setData('email', e.target.value)}
                    value={data.email}
                    placeholder="admin@example.com"
                    type="email"
                  />

                  {/* Gender */}
                  <div className="mb-4 mt-2">
                    <InputLabel htmlFor="gender" value="Admin's Gender" />
                  
                    <div className="flex gap-x-4 px-3 items-center">
                      <TextInput
                        id="gender-male"
                        name="gender"
                        type="radio"
                        value="male"
                        checked={data.gender === 'male'}
                        onChange={(e) => setData('gender', e.target.value)}
                      /> 
                      <span>Male</span>
                    </div>

                    <div className="flex gap-x-4 px-3 items-center">
                      <TextInput
                        id="gender-female"
                        name="gender"
                        type="radio"
                        value="female"
                        checked={data.gender === 'female'}
                        onChange={(e) => setData('gender', e.target.value)}
                      /> 
                      <span>Female</span>
                    </div>

                    <div className="flex gap-x-4 px-3 items-center">
                      <TextInput
                        id="gender-other"
                        name="gender"
                        type="radio"
                        value="other"
                        checked={data.gender === 'other'}
                        onChange={(e) => setData('gender', e.target.value)}
                      /> 
                      <span>Other</span>
                    </div>

                    <InputError message={errors.gender} className="mt-2" />
                  </div>
                </div>

                {/**Second Column */}
                <div>

                  {/* Salary */}
                  <FormInput 
                    labelName="Admin Salary"
                    htmlFor="salary"
                    name="salary"
                    errorMessage={errors.salary}
                    onChange={(e: any) => setData('salary', e.target.value)}
                    type="text"
                    placeholder="10,000"
                    value={data.salary}
                  />

                  {/* Station Name */}
                  <div className="mb-4">
                    <InputLabel
                      htmlFor="station_id"
                      value="Station Name"
                      className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                    />

                    <div className="relative">
                      <input
                        type="text"
                        id="station_id"
                        placeholder="Search station..."
                        className=" px-3 py-2 text-sm rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600"
                        value={stationQuery}
                        onChange={(e) => setStationQuery(e.target.value)}
                        required
                      />
                      {stationQuery && stations.length > 0 && (
                        <div className="absolute z-10 mt-1 bg-white dark:bg-gray-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                          {stations.slice(0, 10).map((station) => (
                            <div
                              key={station.id}
                              className="px-3 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer"
                              onClick={() => {
                                setData('station_id', station.id);
                                setStationQuery(station.name);
                                setStations([]);
                              }}
                            >
                              {station.name}
                            </div>
                          ))}
                        </div>
                      )}
                    </div>

                    <InputError message={errors.station_id} className="mt-2" />
                  </div>

                  {/**Password */}
                  <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <div className='relative'>
                      <TextInput
                          id="password"
                          type={showPassword ? "text" : "password"}
                          name="password"
                          value={data.password}
                          className="mt-1 block w-full"
                          autoComplete="new-password"
                          onChange={(e) => setData('password', e.target.value)}
                          required
                      />
                      <span
                        className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                        onClick={togglePasswordVisibility}
                      >
                        {showPassword ? <Eye size={20} /> : <EyeClosedIcon />}
                      </span>
                    </div>

                        <InputError message={errors.password} className="mt-2" />
                  </div>

                  {/**Password Confirmation */}
                  <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                    <div className='relative'>
                      <TextInput
                          id="password_confirmation"
                          type={showPassword2 ? "text" : "password"}
                          name="password_confirmation"
                          value={data.password_confirmation}
                          className="mt-1 block w-full"
                          autoComplete="new-password"
                          onChange={(e) => setData('password_confirmation', e.target.value)}
                          required
                      />

                      <span
                          className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                          onClick={togglePasswordVisibility2}
                      >
                          {showPassword2 ? <Eye size={20} /> : <EyeClosedIcon />}
                      </span>
                    </div>

                    <InputError message={errors.password_confirmation} className="mt-2" />
                  </div>

                  <div className='mt-4'>
                    <InputLabel  />
                  </div>

                </div>
              </div>
              
              <div className="mt-6 flex justify-center gap-x-2">
                <PrimaryButton 
                  type="submit" 
                  className="ms-4" 
                  disabled={processing}
                >
                  Add User
                </PrimaryButton>

                {/* Cancel button */}
                <PrimaryButton
                  type="button"
                  className="ms-4 bg-red-500 hover:bg-red-600"
                  onClick={() => reset()} // Reset form or you can use back navigation
                >
                  Cancel
                </PrimaryButton>
              </div>

            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayoutSuper>
  );
}

export default Create;
