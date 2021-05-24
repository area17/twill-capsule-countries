<?php

namespace App\Twill\Capsules\Countries\Http\Controllers;

use App\Twill\Capsules\Base\ModuleController;

class CountryController extends ModuleController
{
    protected $moduleName = 'countries';

    protected $titleColumnKey = 'name';

    protected $browserColumns = [
        'name' => [
            'title' => 'Name',
            'field' => 'name',
        ],
    ];
}
