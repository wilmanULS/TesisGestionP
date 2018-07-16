<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\nivelCognoscitivoCrudRequest as StoreRequest;
use App\Http\Requests\nivelCognoscitivoCrudRequest as UpdateRequest;

class nivelCognoscitivoCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\nivelCognoscitivo');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Nivel');
        $this->crud->setEntityNameStrings('nivel', 'niveles');

        $this->crud->setColumns(['descripcion']);
        $this->crud->addColumn([
            'name' => 'dificultad',
            'label' => 'Dificultad',
        ]);

        $this->crud->addField([
            'name' => 'descripcion',
            'label' => 'Nivel Cognoscitivo'

        ]);


        $this->crud->addField([
                'name' => 'dificultad',
                'label' => "Dificultad",
                'type' => 'select_from_array',
                'options' => ['Baja'=>'Baja','Media'=>'Media','Alta'=>'Alta'],
                'allows_null' => false
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