<?php

namespace App\Twill\Capsules\Countries\Http\Requests;

use A17\Twill\Http\Requests\Admin\Request;

class CountryRequest extends Request
{
    public function rulesForCreate()
    {
        return [];
    }

    public function rulesForUpdate()
    {
        return [];
    }
}
