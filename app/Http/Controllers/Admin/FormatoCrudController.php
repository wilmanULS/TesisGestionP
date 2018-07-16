<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FormatoCrudRequest as StoreRequest;
use App\Http\Requests\FormatoCrudRequest as UpdateRequest;

class FormatoCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\formato');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Formato');
        $this->crud->setEntityNameStrings('formato', 'formatos');

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