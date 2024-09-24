<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Vehicle;

class UniqueVehicleCombination implements Rule
{
    protected $plateNumber;
    protected $code;
    protected $region;

    public function __construct($plateNumber, $code, $region)
    {
        $this->plateNumber = $plateNumber;
        $this->code = $code;
        $this->region = $region;
    }

    public function passes($attribute, $value)
    {
        return !Vehicle::where('plate_number', $this->plateNumber)
            ->where('code', $this->code)
            ->where('region', $this->region)
            ->exists();
    }

    public function message()
    {
        return 'The combination of plate number, code, and region must be unique.';
    }
}
