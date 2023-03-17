<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('/');
Route::get('/home', 'HomeController@index')->name('home');

// 1) ADMINISTRACION DE USUARIOS

    //PERSONAS
    include 'administracion/personas/persona.php';

    //USUARIOS
    include 'administracion/usuarios/usuario.php';

    //ROLES
    include 'administracion/roles/rol.php';

    //GRUPOS
    include 'administracion/grupos/grupo.php';

    //TAREAS
    include 'administracion/tareas/tarea.php';

    // COMBOS
    include 'administracion/combos/combos.php';


// 2) MANTENEDORES

    //UBIGEO
    Route::get('/mantenedores-ubigeos', 'Mantenedores\UbigeoController@index')->name('mantenedores.ubigeos.index');
    Route::get('/lista-mantenedores-ubigeos-total-pages', 'Mantenedores\UbigeoController@totalPages')->name('mantenedores.ubigeos.total_pages');
    Route::get('/lista-mantenedores-ubigeos-list/{id}', 'Mantenedores\UbigeoController@list')->name('mantenedores.ubigeos.list');
    Route::post('/lista-mantenedores-ubigeos-search', 'Mantenedores\UbigeoController@listSearch')->name('mantenedores.ubigeos.search');
    Route::post('/store-data-ubicacion', 'Mantenedores\UbigeoController@storeDataUbigeos')->name('mantenedores.ubigeos.store');
    Route::post('/delete-ubigeo', 'Mantenedores\UbigeoController@deleteDataUbigeos')->name('mantenedores.ubigeos.delete');
    Route::post('/active-ubigeo', 'Mantenedores\UbigeoController@activeDataUbigeos')->name('mantenedores.ubigeos.active');
    Route::post('/update-data-ubigeos', 'Mantenedores\UbigeoController@updateDataUbigeos')->name('mantenedores.ubigeos.update');
    Route::get('/datos-ubigeos-edit/{id}', 'Mantenedores\UbigeoController@editDataUbigeos')->name('mantenedores.ubigeos.edit');

    //ARANCELES
    Route::get('/mantenedores-aranceles', 'Mantenedores\ArancelesController@index')->name('mantenedores.aranceles.index');
    Route::get('/lista-mantenedores-aranceles-total-pages', 'Mantenedores\ArancelesController@totalPages')->name('mantenedores.aranceles.total_pages');
    Route::get('/lista-mantenedores-aranceles-list/{id}', 'Mantenedores\ArancelesController@list')->name('mantenedores.aranceles.list');
    Route::post('/lista-mantenedores-aranceles-search', 'Mantenedores\ArancelesController@listSearch')->name('mantenedores.aranceles.search');
    Route::post('/store-data-aranceles', 'Mantenedores\ArancelesController@storeDataAranceles')->name('mantenedores.aranceles.store');
    Route::post('/delete-arancel', 'Mantenedores\ArancelesController@deleteDataAranceles')->name('mantenedores.aranceles.delete');
    Route::post('/active-arancel', 'Mantenedores\ArancelesController@activeDataAranceles')->name('mantenedores.aranceles.active');
    Route::post('/update-data-aranceles', 'Mantenedores\ArancelesController@updateDataAranceles')->name('mantenedores.aranceles.update');
    Route::get('/datos-aranceles-edit/{id}', 'Mantenedores\ArancelesController@editDataAranceles')->name('mantenedores.aranceles.edit');
    Route::get('/lista-aniosaranceles-text', 'Mantenedores\ArancelesController@listAniosAranceles')->name('mantenedores.aranceles.listAnios');


    //FECHAS DE VENCIMIENTO
    Route::get('/mantenedores-fechas_vencimiento', 'Mantenedores\FechasVencimientoController@index')->name('mantenedores.fechas_vencimiento.index');




    Route::get('/lista-mantenedores-aranceles-total-juntas', 'Mantenedores\ArancelesController@listArancelesTotalJuntas')->name('mantenedores.aranceles.total_juntas');




































// 2) TRAMITE DOCUMENTARIO

//EXPEDIENTE
Route::get('/tramite-documentario-expediente', 'TramiteDocumentario\ExpedienteController@index')->name('tramite_documentario.expediente.index');
Route::get('/lista-tramite_documentario-expedientes-list', 'TramiteDocumentario\ExpedienteController@list')->name('tramite_documentario.expediente.list');
Route::post('/lista-tramite_documentario-expedientes-search', 'TramiteDocumentario\ExpedienteController@listSearch')->name('tramite_documentario.expediente.search');
Route::get('/datos-tramite_documentario-expediente-edit/{id}/{anio}', 'TramiteDocumentario\ExpedienteController@editDatExpediente')->name('tramite_documentario.expediente.edit');
Route::post('/lista-tramite_documentario-persona-select-search', 'TramiteDocumentario\ExpedienteController@selectPersonSearch')->name('tramite_documentario.expediente.select.search');
Route::post('/update-tramite_documentario-data-expediente', 'TramiteDocumentario\ExpedienteController@updateDataExpediente')->name('tramite_documentario.expediente.update');
Route::post('/delete-expediente-tramite-documentario', 'TramiteDocumentario\ExpedienteController@deleteDataExpediente')->name('tramite_documentario.expediente.delete');
Route::post('/update-tramite_documentario-adjuntar-archivo-expediente', 'TramiteDocumentario\ExpedienteController@adjuntarArchivoExpediente')->name('tramite_documentario.archivo.expediente.adjuntar');


//CAJA

Route::get('/mantenedores-caja-lista', 'Mantenedores\CajaController@index')->name('mantendores.caja.index');
Route::get('/lista-mantenedores-caja-total-pages', 'Mantenedores\CajaController@getCajaTotalPage')->name('mantenedores.caja.getCajaTotalPage');
Route::get('/lista-mantenedores-caja-total-list/{id}', 'Mantenedores\CajaController@list')->name('mantenedores.caja.list');

// 3) INFORMACION GENERAL
// CONTRIBUYENTES
// Route::get('/informacion_general-contribuyentes', 'InformacionGeneral\ContribuyentesController@index')->name('informacion_general.contribuyentes.index');
