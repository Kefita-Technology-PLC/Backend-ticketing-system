import React, { FormEventHandler, useEffect, useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AuthenticatedLayoutSuper from '@/Layouts/AuthenticatedLayoutSuper';
import FormInput from '@/Components/FormInput';
import PrimaryButton from '@/Components/PrimaryButton';
import { Eye } from 'lucide-react';
import { EyeClosedIcon } from '@radix-ui/react-icons';
import { allPermissions } from '@/constants/allPermissions';
import InputError from '@/Components/InputError';

interface User {
  id: number,
  name: string;
  phone_no: string;
  email: string;
  gender: string;
  salary: string;
  station_id: string;
  password: string;
  password_confirmation: string;
  permissions: string[];
}

interface EditUser {
  user: {
    data: User
  };
}

function Edit({ user }: EditUser) {
  const userData = user.data
  const [showPassword, setShowPassword] = useState(false);
  const [showPassword2, setShowPassword2] = useState(false);
  const [stations, setStations] = useState<{ id: string; name: string }[]>([]);
  const [stationQuery, setStationQuery] = useState('');

  // Initialize the form state with user object values
  const { data, setData, put, processing, errors, reset } = useForm({
    name: userData.name,
    phone_no: userData.phone_no,
    email: userData.email,
    gender: userData.gender,
    salary: userData.salary,
    station_id: userData.station_id,
    password: '', // Keeping password empty for security reasons
    password_confirmation: '',
    permissions: userData.permissions || [],
  });

  const [selectedPermissions, setSelectedPermissions] = useState<string[]>(userData.permissions || []);

  console.log(user.data)

  const handlePermissionChange = (permission: string) => {
    const updatedPermissions = selectedPermissions.includes(permission)
      ? selectedPermissions.filter((p) => p !== permission)
      : [...selectedPermissions, permission];

    setSelectedPermissions(updatedPermissions);
    setData('permissions', updatedPermissions);
  };

  const submit: FormEventHandler = (e) => {
    e.preventDefault();
    put(route('user-managements.update', { user_management: userData.id }), {
      onSuccess: () => {
        // Handle success (e.g., show a success message, redirect)
      },
      onError: (errors) => {
        console.log('Validation errors:', errors);
      }
    });
  };

  const fetchStations = async (query: string) => {
    try {
      const response = await fetch(`/api/v1/stations-search?q=${query}`);
      const data = await response.json();
      setStations(Array.isArray(data) ? data : []);
    } catch (error) {
      console.error('Error fetching stations:', error);
      setStations([]);
    }
  };

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

  useEffect(()=>{
    fetchStationName(data.station_id)
  },[])

  useEffect(() => {
    if (stationQuery.length > 0) {
      fetchStations(stationQuery);
    }
  }, [stationQuery]);

  const togglePasswordVisibility = () => {
    setShowPassword(!showPassword);
  };

  const togglePasswordVisibility2 = () => {
    setShowPassword2(!showPassword2);
  };

  return (
    <AuthenticatedLayoutSuper
      header={<div><h1>Edit User</h1></div>}
    >
      <Head title="User Edit" />
      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <form onSubmit={submit}>
              <div className='flex justify-center gap-x-20 flex-col sm:flex-row'>
                <div>
                  <FormInput
                    labelName='Admin Name'
                    htmlFor='name'
                    name='name'
                    errorMessage={errors.name}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('name', e.target.value)}
                    value={data.name}
                    placeholder="Jon Doe"
                    type="text"
                  />

                  <FormInput
                    labelName='Admin Phone Number'
                    htmlFor='phone_no'
                    name='phone_no'
                    errorMessage={errors.phone_no}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('phone_no', e.target.value)}
                    value={data.phone_no}
                    placeholder="+251xxxxxxxxx"
                    type="text"
                  />

                  <FormInput
                    labelName='Admin Email'
                    htmlFor='email'
                    name='email'
                    errorMessage={errors.email}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('email', e.target.value)}
                    value={data.email}
                    placeholder="admin@example.com"
                    type="email"
                  />

                  <div className="mb-4 mt-2">
                    <label htmlFor="gender" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin's Gender</label>
                    <div className="flex gap-x-4 px-3 items-center">
                      <input
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
                      <input
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
                      <input
                        id="gender-other"
                        name="gender"
                        type="radio"
                        value="other"
                        checked={data.gender === 'other'}
                        onChange={(e) => setData('gender', e.target.value)}
                      />
                      <span>Other</span>
                    </div>
                    <InputError message={errors.gender} />
                  </div>
                </div>

                <div>
                  <FormInput
                    labelName="Admin Salary"
                    htmlFor="salary"
                    name="salary"
                    errorMessage={errors.salary}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('salary', e.target.value)}
                    type="text"
                    placeholder="10,000"
                    value={data.salary}
                  />

                  {/**Station Name */}
                  <div className="mb-4">
                    <label htmlFor="station_id" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                      Station Name
                    </label>
                    <div className="relative">
                      <input
                        type="text"
                        id="station_id"
                        placeholder="Search station..."
                        className="px-3 py-2 text-sm rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600"
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
                    <InputError message={errors.station_id} />
                  </div>

                  {/**Password */}
                  <div className="mt-4">
                    <label htmlFor="password" className="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div className='relative'>
                      <input
                        id="password"
                        type={showPassword ? "text" : "password"}
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                      />
                      <span
                        className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                        onClick={togglePasswordVisibility}
                      >
                        {showPassword ? <Eye size={20} /> : <EyeClosedIcon />}
                      </span>
                    </div>
                    <InputError message={errors.password} />
                  </div>

                    {/**Password Confirmation */}
                  <div className="mt-4">
                    <label htmlFor="password_confirmation" className="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <div className='relative'>
                      <input
                        id="password_confirmation"
                        type={showPassword2 ? "text" : "password"}
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                      />
                      <span
                        className="absolute inset-y-0 right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                        onClick={togglePasswordVisibility2}
                      >
                        {showPassword2 ? <Eye size={20} /> : <EyeClosedIcon />}
                      </span>
                    </div>
                    <InputError message={errors.password_confirmation} />
                  </div>
                </div>
              </div>

              {/**Permissions */}
              <div className="mt-6">
                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                <div className="flex flex-wrap gap-4 mt-3">
                  {allPermissions.map((permission, index) => (
                    <label key={index} className="inline-flex items-center space-x-2">
                      <input
                        type="checkbox"
                        className="form-checkbox h-4 w-4 text-indigo-600 dark:text-indigo-400"
                        checked={selectedPermissions.includes(permission.name)}
                        onChange={() => handlePermissionChange(permission.name)}
                      />
                      <span className="text-sm text-gray-700 dark:text-gray-300">{permission.name}</span>
                    </label>
                  ))}
                </div>

                <InputError message={errors.permissions} />
              </div>

              <div className="mt-6 flex justify-end">
                <PrimaryButton className="ml-4" disabled={processing}>
                  Update User
                </PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayoutSuper>
  );
}

export default Edit;