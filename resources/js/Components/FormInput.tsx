import InputError from "./InputError"
import InputLabel from "./InputLabel"
import TextInput from "./TextInput"

interface FormInputProps{
  labelName: string,
  htmlFor: string,
  name: string,
  errorMessage: any,
  onChange: any,
  value: any,
  type: string,
  placeholder: string
}

function FormInput({labelName, htmlFor, name, errorMessage, onChange, value, type, placeholder}:FormInputProps) {
  return (
    <div className='mb-4'>
      <InputLabel 
        htmlFor={htmlFor}
        value={labelName}

      />

      <TextInput 
        id={name}
        name={name}
        value={value}
        onChange={onChange}
        type={type}
        placeholder={placeholder}
        required
      />
      
      <InputError message={errorMessage} className='mt-2' />
    </div>
  )
}

export default FormInput
