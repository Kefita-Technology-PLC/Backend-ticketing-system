<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Tariff;

class UniqueOriginDestination implements Rule
{
    protected $origin;
    protected $destination;

    public function __construct($origin, $destination)
    {
        $this->origin = $origin;
        $this->destination = $destination;
    }

    public function passes($attribute, $value)
    {
        return !Tariff::where('origin', $this->origin)
                      ->where('destination', $this->destination)
                      ->exists();
    }

    public function message()
    {
        return 'The combination of origin and destination must be unique.';
    }
}
