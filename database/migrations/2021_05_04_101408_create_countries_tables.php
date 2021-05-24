<?php

use App\Twill\Capsules\Base\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTables extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('cca2', 10)->nullable();
            $table->string('cca3', 10)->nullable();

            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
        });

        Schema::create('country_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'country');

            $table->string('name', 200)->nullable();

            $this->createSeoFields($table);
        });

        Schema::create('country_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'country');
        });

        Schema::create('country_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'country');
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_revisions');
        Schema::dropIfExists('country_translations');
        Schema::dropIfExists('country_slugs');
        Schema::dropIfExists('countries');
    }
}
