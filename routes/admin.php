<?php

use Illuminate\Support\Facades\Route;

Route::prefix('destinations')->group(function () {
    Route::module('countries');
});
