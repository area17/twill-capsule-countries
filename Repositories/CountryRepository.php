<?php

namespace App\Twill\Capsules\Countries\Repositories;

use App\Twill\Capsules\Cities\Models\City;
use App\Twill\Capsules\Base\ModuleRepository;
use App\Twill\Capsules\Countries\Models\Country;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;

class CountryRepository extends ModuleRepository
{
    use HandleMedias, HandleTranslations, HandleSlugs, HandleRevisions;

    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    public function getFormFields($object): array
    {
        return $this->getManyToManyBrowserField($object, parent::getFormFields($object), 'cities', 'destinations');
    }

    public function afterSave($object, $fields)
    {
        $this->updateHasManyBrowser($object, $fields, 'cities', 'country_id', City::class);

        parent::afterSave($object, $fields);
    }
}
