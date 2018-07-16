<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\IdiomaCrudRequest as StoreRequest;
use App\Http\Requests\FormatoCrudRequest as UpdateRequest;

class IdiomaCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\idioma');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Idioma');
        $this->crud->setEntityNameStrings('idioma', 'idiomas');

        $this->crud->setColumns(['descripcion']);
        $this->crud->addField([
            'name' => 'descripcion',
            'label' => 'Idioma'

        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}