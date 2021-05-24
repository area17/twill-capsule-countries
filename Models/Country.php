<?php

namespace App\Twill\Capsules\Countries\Models;

use App\Twill\Capsules\Base\Model;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Twill\Capsules\Cities\Models\City;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasTranslation, HasSlug, HasRevisions;

    protected $fillable = ['published', 'code'];

    public $translatedAttributes = ['name', 'active'];

    public $slugAttributes = ['name'];

    public string $titleColumnKey = 'name';

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
