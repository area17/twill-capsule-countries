<?php

namespace App\Twill\Capsules\Countries\Database\Seeds;

use ForceUTF8\Encoding;
use Illuminate\Database\Seeder;
use App\Twill\Capsules\Cities\Models\City;
use PragmaRX\Coollection\Package\Coollection;
use App\Twill\Capsules\Countries\Models\Country;

class Countries extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        City::truncate();

        app(\PragmaRX\Countries\Package\Countries::class)
            ->all()
            //->where('cca3', 'ALA')
            ->each(fn($country) => $this->importCountry($country));
    }

    private function importCountry($country)
    {
        echo $this->getName($country, 'en') . " \n";

        $newCountry = $this->createCountry($country);

        $cities = $country->hydrate('cities')->cities;

        $cities->each(fn($city) => $this->createCity($city, $newCountry));

        echo 'Cities: ' . $cities->count() . "\n\n";
    }

    public function getName($country, $locale): ?string
    {
        $locales = [
            'en' => 'eng',
            'fr' => 'fra',
            'es' => 'esp',
            'it' => 'ita',
            'pt' => 'por',
            'pt_br' => 'por',
        ];

        $name = null;

        $nameSource =
            filled(is_bool($country['independent'] ?? null)) && is_array($country['independent'] ?? null)
                ? $country['independent']
                : $country;

        if ($locale === 'en') {
            $name = filled($name) ? $name : $country['name']['common'] ?? null;

            if ($name === null) {
                $name = is_string($country['name']) ? $country['name'] : null;
            }
        }

        $name = filled($name) ? $name : $country["name_$locale"] ?? ($nameSource["name_$locale"] ?? null);

        $name = filled($name)
            ? $name
            : $country['translations'][$locales[$locale]]['common'] ??
                ($nameSource['translations'][$locales[$locale]]['common'] ?? null);

        //        echo "---------------------------------------\n";
        //        for ($x = 0; $x < strlen($name); $x++) {
        //            echo ord($name[$x]) . '=' . $name[$x] . ' ** ';
        //        }
        //        echo "\n";
        //        dump(
        //            $country['cca3'] .
        //                " - $name: " .
        //                mb_detect_encoding($name) .
        //                " - {$this->decode($name)}: " .
        //                mb_detect_encoding($this->decode($name)),
        //            $name == $name,
        //            $name == $this->decode($name),
        //        );
        //
        //        echo "\n\n";

        return $this->decode($name);
    }

    /**
     * @param $country
     * @return mixed
     */
    private function createCountry($country)
    {
        return repository('countries')->create([
            'cca2' => $country->cca2,

            'cca3' => $country->cca3,

            'name' => [
                'en' => $this->getName($country, 'en'),

                'fr' => $this->getName($country, 'fr'),

                'es' => $this->getName($country, 'es'),

                'it' => $this->getName($country, 'it'),

                'pt-br' => $this->getName($country, 'pt_br') ?? $this->getName($country, 'pt'),
            ],

            'latitude' => $country['latitude'] ?? ($country['geo']['latitude_desc'] ?? null),

            'longitude' => $country['longitude'] ?? ($country['geo']['longitude_desc'] ?? null),
        ]);
    }

    private function createCity($city, mixed $country)
    {
        if (!$city instanceof Coollection) {
            return;
        }

        $city = repository('cities')->create([
            'name' => [
                'en' => $this->getName($city, 'en'),

                'fr' => $this->getName($city, 'fr'),

                'es' => $this->getName($city, 'es'),

                'it' => $this->getName($city, 'it'),

                'pt-br' => $this->getName($city, 'pt_br') ?? $this->getName($city, 'pt'),
            ],

            'latitude' => $city['latitude'] ?? ($city['geo']['latitude_desc'] ?? null),

            'longitude' => $city['longitude'] ?? ($city['geo']['longitude_desc'] ?? null),
        ]);

        $city->country_id = $country->id;

        $city->save();

        return $city;
    }

    protected function decode(?string $name): ?string
    {
        if (blank($name)) {
            return $name;
        }

        if (mb_detect_encoding($name) !== 'UTF-8') {
            return Encoding::toUTF8($name);
        }

        return Encoding::fixUTF8($name);
    }
}
