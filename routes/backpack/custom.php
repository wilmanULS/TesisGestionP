<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {

    CRUD::resource('Periodo','PeriodoCrudController');
    CRUD::resource('Formato','FormatoCrudController');
    CRUD::resource('Recurso','recursoEducativoCrudController');
    CRUD::resource('Idioma','IdiomaCrudController');
    CRUD::resource('Dificultad','DificultadCrudController');
    CRUD::resource('Nivel','nivelCognoscitivoCrudController');
    // custom admin routes
}); // this should be the absolute last line of this file
