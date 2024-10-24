<?php

namespace App\Repositories;

use App\Interfaces\CountryInterface;
use App\Models\Country;

class CountryRepository implements CountryInterface
{
    private $country;

    public function __construct()
    {
        $this->country = new Country;
    }

    public function fetchCountries($request)
    {
        $search = $request->get('query');
        $countries = $this->country->where('name', 'like', '%'.$search.'%')->get(['id', 'name']);

        return $countries;
    }
}
