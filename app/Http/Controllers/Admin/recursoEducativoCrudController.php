<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\recursoEducativoCrudRequest as StoreRequest;
use App\Http\Requests\recursoEducativoCrudRequest as UpdateRequest;

class recursoEducativoCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\recursoEducativo');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Recurso');
        $this->crud->setEntityNameStrings('Recurso Educativo', 'Recursos Educativos');

        $this->crud->setColumns(['descripcion']);
        $this->crud->addField([
            'name' => 'descripcion',
            'label' => 'Recurso Educativos'

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