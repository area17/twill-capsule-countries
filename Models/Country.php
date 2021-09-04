<?php

namespace App\Twill\Capsules\Countries\Models;

use App\Twill\Capsules\Base\Model;
use App\Twill\Capsules\Base\Crops;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use App\Twill\Capsules\Cities\Models\City;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasMedias, HasTranslation, HasSlug, HasRevisions;

    protected $fillable = ['published', 'cca2', 'cca3', 'latitude', 'longitude'];

    public $translatedAttributes = ['name', 'active', 'seo_title', 'seo_description'];

    public $slugAttributes = ['name'];

    public $titleColumnKey = 'name';

    public $filterableColumns = ['name'];

    public $mediasParams = Crops::COUNTRY;

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
