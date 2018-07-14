<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PeriodoCrudRequest as StoreRequest;
use App\Http\Requests\PeriodoCrudRequest as UpdateRequest;

class PeriodoCrudController extends CrudController {

    public function setup() {
        $this->crud->setModel('App\Models\periodoAcademico');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/Periodo');
        $this->crud->setEntityNameStrings('Periodo Académico', 'Periodos Académicos');

        $this->crud->setColumns(['name']);
        $this->crud->addField([
            'name' => 'name',
            'label' => 'Periodo Academico'

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