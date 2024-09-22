import * as React from "react";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/Components/ui/select";

interface SelectInputProps {
  value: string;
  onChange: (value: string) => void;
  children: React.ReactNode;
  className?: string;
  placeholder?: string;
}

export default function SelectInput({
  value,
  onChange,
  children,
  className = '',
  placeholder = 'Select',
}: SelectInputProps) {
  return (
    <Select value={value} onValueChange={onChange}>
      <SelectTrigger className={`w-full ${className}`}>
        <SelectValue placeholder={placeholder} />
      </SelectTrigger>
      <SelectContent>{children}</SelectContent>
    </Select>
  );
}
