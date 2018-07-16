<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DificultadCrudRequest as StoreRequest;
use App\Http\Requests\DificultadCrudRequest as UpdateRequest;

class DificultadCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\dificultad');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Dificultad');
        $this->crud->setEntityNameStrings('dificultad', 'dificultades');

        $this->crud->setColumns(['descripcion']);
        $this->crud->addField([
            'name' => 'descripcion',
            'label' => 'Formato'

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