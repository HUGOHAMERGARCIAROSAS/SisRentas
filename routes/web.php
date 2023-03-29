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
    Route::get('/lista-mantenedores-aranceles-total-juntas', 'Mantenedores\ArancelesController@listArancelesTotalJuntas')->name('mantenedores.aranceles.total_juntas');

    //FECHAS DE VENCIMIENTO
    Route::get('/mantenedores-fechas_vencimiento', 'Mantenedores\FechasVencimientoController@index')->name('mantenedores.fechas_vencimiento.index');
    Route::get('/lista-fecha-vencimientos-text', 'Mantenedores\FechasVencimientoController@listFechaVencimientos')->name('mantenedores.fechas_vencimiento.list');
    Route::post('/store-data-fecha-vencimientos', 'Mantenedores\FechasVencimientoController@storeDataFechaVencimientos')->name('mantenedores.fechas_vencimiento.store');
    Route::get('/get-lista-fecha-vencimiento-anios-text', 'Mantenedores\FechasVencimientoController@getListAniosFechasVencimientos')->name('mantenedores.fechas_vencimiento.getListAnios');
    Route::post('/lista-mantenedores-fecha-vencimientos-search', 'Mantenedores\FechasVencimientoController@listSearch')->name('mantenedores.fechas_vencimiento.search');
    Route::get('/datos-fecha-vencimientos-edit/{id}', 'Mantenedores\FechasVencimientoController@editDataFechaVencimientos')->name('mantenedores.fechas_vencimiento.edit');
    Route::post('/update-data-fecha-vencimientos', 'Mantenedores\FechasVencimientoController@updateDataFechaVencimientos')->name('mantenedores.fechas_vencimiento.update');

    //CLASIFICADORES
    Route::get('/mantenedores-clasificador-ingresos', 'Mantenedores\ClasificadorIngresosController@index')->name('mantenedores.clasificador_ingresos.index');
    Route::get('/lista-aniosclasificadoringresos-text', 'Mantenedores\ClasificadorIngresosController@listAniosClasificadorIngresos')->name('mantenedores.clasificador_ingresos.listAnios');
    Route::get('/lista-mantenedores-clasificador-ingresos-total-pages', 'Mantenedores\ClasificadorIngresosController@totalPages')->name('mantenedores.clasificador_ingresos.total_pages');
    Route::get('/lista-mantenedores-clasificador-ingresos-list/{id}', 'Mantenedores\ClasificadorIngresosController@list')->name('mantenedores.clasificador_ingresos.list');
    Route::post('/lista-mantenedores-clasificador-ingresos-search', 'Mantenedores\ClasificadorIngresosController@listSearch')->name('mantenedores.clasificador_ingresos.search');
    Route::post('/delete-clasificador-ingresos', 'Mantenedores\ClasificadorIngresosController@deleteDataClasificadorIngresos')->name('mantenedores.clasificador_ingresos.delete');
    Route::post('/active-clasificador-ingresos', 'Mantenedores\ClasificadorIngresosController@activeDataClasificadorIngresos')->name('mantenedores.clasificador_ingresos.active');
    Route::post('/store-data-clasificador-ingresos', 'Mantenedores\ClasificadorIngresosController@storeDataClasificadorIngresos')->name('mantenedores.clasificador_ingresos.store');
    Route::get('/datos-clasificador-ingresos-edit/{id}', 'Mantenedores\ClasificadorIngresosController@editDataClasificadorIngresos')->name('mantenedores.clasificador_ingresos.edit');
    Route::post('/update-data-clasificador-ingresos', 'Mantenedores\ClasificadorIngresosController@updateDataClasificadorIngresos')->name('mantenedores.clasificador_ingresos.update');

     //ARANCELES RUSTICOS
     Route::get('/mantenedores-aranceles-rustico', 'Mantenedores\ArancelesRusticosController@index')->name('mantenedores.aranceles_rusticos.index');
     Route::get('/lista-mantenedores-aranceles-rusticos-total-pages', 'Mantenedores\ArancelesRusticosController@totalPages')->name('mantenedores.aranceles_rusticos.total_pages');
     Route::get('/lista-mantenedores-aranceles-rusticos-list/{id}', 'Mantenedores\ArancelesRusticosController@list')->name('mantenedores.aranceles_rusticos.list');
     Route::post('/lista-mantenedores-aranceles-rusticos-search', 'Mantenedores\ArancelesRusticosController@listSearch')->name('mantenedores.aranceles_rusticos.search');
     Route::post('/store-data-aranceles-rustico', 'Mantenedores\ArancelesRusticosController@storeDataArancelesRustico')->name('mantenedores.aranceles.store');
     Route::post('/delete-arancel-rustico', 'Mantenedores\ArancelesRusticosController@deleteDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.delete');
     Route::post('/active-arancel-rustico', 'Mantenedores\ArancelesRusticosController@activeDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.active');
     Route::post('/update-data-aranceles-rustico', 'Mantenedores\ArancelesRusticosController@updateDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.update');
     Route::get('/datos-aranceles-rusticos-edit/{id}', 'Mantenedores\ArancelesRusticosController@editDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.edit');
     Route::get('/lista-aniosaranceles-rusticos-text', 'Mantenedores\ArancelesRusticosController@listAniosArancelesRusticos')->name('mantenedores.aranceles_rusticos.listAnios');


       //TRIBUTOS
       Route::get('/mantenedores-tributos', 'Mantenedores\TributosController@index')->name('mantenedores.tributos.index');
    //    Route::get('/lista-mantenedores-aranceles-rusticos-total-pages', 'Mantenedores\ArancelesRusticosController@totalPages')->name('mantenedores.aranceles_rusticos.total_pages');
    //    Route::get('/lista-mantenedores-aranceles-rusticos-list/{id}', 'Mantenedores\ArancelesRusticosController@list')->name('mantenedores.aranceles_rusticos.list');
    //    Route::post('/lista-mantenedores-aranceles-rusticos-search', 'Mantenedores\ArancelesRusticosController@listSearch')->name('mantenedores.aranceles_rusticos.search');
    //    Route::post('/store-data-aranceles-rustico', 'Mantenedores\ArancelesRusticosController@storeDataArancelesRustico')->name('mantenedores.aranceles.store');
    //    Route::post('/delete-arancel-rustico', 'Mantenedores\ArancelesRusticosController@deleteDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.delete');
    //    Route::post('/active-arancel-rustico', 'Mantenedores\ArancelesRusticosController@activeDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.active');
    //    Route::post('/update-data-aranceles-rustico', 'Mantenedores\ArancelesRusticosController@updateDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.update');
    //    Route::get('/datos-aranceles-rusticos-edit/{id}', 'Mantenedores\ArancelesRusticosController@editDataArancelesRusticos')->name('mantenedores.aranceles_rusticos.edit');
    //    Route::get('/lista-aniosaranceles-rusticos-text', 'Mantenedores\ArancelesRusticosController@listAniosArancelesRusticos')->name('mantenedores.aranceles_rusticos.listAnios');











    //COMBOS
    Route::get('/lista-general-combos-meses', 'CombosController@meses')->name('general.combos.meses'); // SOLO MESES
    Route::get('/lista-general-combos-meses-todo', 'CombosController@mesesTodos')->name('general.combos.meses.todos'); // MESES TODOS
    Route::get('/lista-tipoclasificacion-arancelrustico-text', '@clasificacionArancelRustico')->name('general.combos.clasificacion.arancel_rustico'); // CLASIFICACION DE ARANCELES RUSTICOS
    Route::get('/lista-tipocategoria-arancelrustico-text', 'CombosController@categoriaArancelRustico')->name('general.combos.categoria.arancel_rustico'); // CATEGORIA DE ARANCELES RUSTICOS

    Route::get('/lista-tributos-grupos-text', 'CombosController@listGrupoTributos')->name('general.combos.tributos.grupo');
    Route::get('/lista-tributos-genericos-text', 'CombosController@lisGenericoTributos')->name('general.combos.tributos.generico');
    Route::get('/lista-tributos-subgenericos-text', 'CombosController@listSubgenericosTributos')->name('general.combos.tributos.subgenerico');
    Route::get('/lista-tributos-especifica-text', 'CombosController@listEspecificaTributos')->name('general.combos.tributos.especifica');
    Route::get('/lista-tributos-area-text', 'CombosController@listAreaTributos')->name('general.combos.tributos.area');





































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
