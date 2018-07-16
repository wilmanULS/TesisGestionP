<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
    // Backpack\MenuCRUD
    CRUD::resource('menu-item', 'MenuItemCrudController');
});

//ruta ajax nivel/asignatura
Route::get('/create/asignaturas/{nivel}','AsignaturasController@getAsignature');
//ruta descricpion cognoscitiva
Route::get('/Docente/descripcion/','competenciaController@getDescripcion')->name('Docente.descripcion');
//ruta verbo taxonomia
Route::get('/Docente/verboTaxonomia/','TaxonomiaController@getVerbo')->name('Docente.verboTaxonomia');
//get nombre
Route::get('/Materia/descripcion/','AsignaturasController@getNombre')->name('Materia.descripcion');
//ruta guardar

Route::post('/create/asignaturas/save','docenteAsignaturaController@saveDocAsigDB');
Route::post('/contenido/save','competenciaController@saveContenido')->name('Competencias.save');
Route::get('/Docente/competencias','docenteController@tablaCompetencias');
Route::get('/Docente/index/AgregarContenido','competenciaController@viewCompetencias');
Route::get('/Docente/competencias/delete','competenciaController@deleteCompetencia')->name('Competencias.delete');
//ruta edit ajax

Route::get('/Academico/edit/update','UserController@actualizar')->name('Academico.update');
Route::get('/Asignatura/delete','docenteAsignaturaController@delete')->name('Asignatura.delete');
Route::get('Docente/funciones/contenido/{idM}','docenteController@definirContenido')->name('Docente.Fcontenido');

//route editar competencias
Route::get('Docente/editarCompetencias/{id}/{idComp}','competenciaController@editCompetencias')->name('Docente.editarCompetencias');
Route::post('Docente/updateCompetencias','competenciaController@updateCompetencia')->name('Competencias.update');
//route ingresar contenido
Route::get('Docente/verSemanas/{id}','planController@verSemanas');
Route::get('semanas/semana1/{idAsignatura}/{idSemana}/{index}','planController@ingresarContenido')->name('Docente.contenido');
Route::get('Docente/verSemanas/{id}','planController@verSemanas');
Route::get('semanas/semana1/{id}','planController@ingresarContenido')->name('Docente.contenido');

Route::post('Docente/contenido/save','planController@savePlan')->name('Docente.contenidoSave');

//crudAsignaturas
Route::get('/admin/indexAsignaturas','AsignaturasController@index')->name('Administrador.indexAsignatura');
Route::get('/admin/indexAsignaturas/create','AsignaturasController@create')->name('Administrador.createAsignatura');
Route::post('/admin/indexAsignaturas/create/save','AsignaturasController@saveAsignatura')->name('Administrador.saveAsignatura');
Route::get('/admin/indexAsignaturas/edit/{id}','AsignaturasController@editAsignatura')->name('Administrador.editAsignatura');
Route::post('/admin/indexAsignaturas/edit/update','AsignaturasController@updateAsignatura')->name('Administrador.updateAsignatura');

//routes OA
Route::post('Repositorio/ingresarOA/saveOA','ObjetoController@saveOA')->name('Repositorio.saveOA');
Route::get('/Docente/Indextemas/ingresarOA','planController@indexTemas');
Route::get('/Docente/verTemas/temas/{id}','planController@getTemas');
Route::get('/Docente/verTemas/','planController@getContenido')->name('Docente.temas');
Route::get('/Docente/verTemas/view','planController@getAllTemas')->name('Docente.verTemas');

Route::resource('Academico/designarAsignatura','docenteAsignaturaController');
Route::resource('/create','UserController');
//DOCENTE

Route::resource('Docente/index','docenteController');
Route::resource('Docente/funciones','competenciaController ');

//routes objetos de Aprendizaje
Route::get('Repositorio/ingresarOA/{id}','ObjetoController@index');

