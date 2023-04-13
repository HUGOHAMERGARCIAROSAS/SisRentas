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
    Route::get('/lista-mantenedores-tributos-total-pages', 'Mantenedores\TributosController@totalPages')->name('mantenedores.tributos.total_pages');
    Route::get('/lista-mantenedores-tributos-list/{id}', 'Mantenedores\TributosController@list')->name('mantenedores.tributos.list');
    Route::post('/lista-mantenedores-tributos-search', 'Mantenedores\TributosController@listSearch')->name('mantenedores.tributos.search');
    Route::post('/store-data-tributos', 'Mantenedores\TributosController@storeDataTributos')->name('mantenedores.tributos.store');
    Route::post('/delete-tributos', 'Mantenedores\TributosController@deleteDataTributos')->name('mantenedores.tributos.delete');
    Route::post('/active-tributos', 'Mantenedores\TributosController@activeDataTributos')->name('mantenedores.tributos.active');
    Route::post('/update-data-tributos', 'Mantenedores\TributosController@updateDataTributos')->name('mantenedores.tributos.update');
    Route::get('/datos-tributos-edit/{id}', 'Mantenedores\TributosController@editDataTributos')->name('mantenedores.tributos.edit');

    //IPM REAJUSTE
    Route::get('/mantenedores-ipm-reajuste', 'Mantenedores\IpmReajusteController@index')->name('mantenedores.ipm_reajuste.index');
    Route::get('/lista-mantenedores-ipm-reajuste-total-pages', 'Mantenedores\IpmReajusteController@totalPages')->name('mantenedores.ipm_reajuste.total_pages');
    Route::get('/lista-mantenedores-ipm-reajuste-list/{id}', 'Mantenedores\IpmReajusteController@list')->name('mantenedores.ipm_reajuste.list');
    Route::post('/lista-mantenedores-ipm-reajuste-search', 'Mantenedores\IpmReajusteController@listSearch')->name('mantenedores.ipm_reajuste.search');
    Route::post('/store-data-ipm-reajuste', 'Mantenedores\IpmReajusteController@storeDataIpmReajuste')->name('mantenedores.ipm_reajuste.store');
    Route::post('/delete-ipm-reajuste', 'Mantenedores\IpmReajusteController@deleteDataIpmReajuste')->name('mantenedores.ipm_reajuste.delete');
    Route::post('/active-ipm-reajuste', 'Mantenedores\IpmReajusteController@activeDataIpmReajuste')->name('mantenedores.ipm_reajuste.active');
    Route::post('/update-data-ipm-reajuste', 'Mantenedores\IpmReajusteController@updateDataIpmReajuste')->name('mantenedores.ipm_reajuste.update');
    Route::get('/datos-ipm-reajuste-edit/{id}', 'Mantenedores\IpmReajusteController@editDataIpmReajuste')->name('mantenedores.ipm_reajuste.edit');
    Route::get('/lista-anios-ipm-reajuste-text', 'Mantenedores\IpmReajusteController@listAniosIpmReajuste')->name('mantenedores.ipm_reajuste.listAnios');

    //IPM ALCABALA
    Route::get('/mantenedores-ipm-alcabala', 'Mantenedores\IpmAlcabalaController@index')->name('mantenedores.ipm_alcabala.index');
    Route::get('/lista-mantenedores-ipm-alcabala-total-pages', 'Mantenedores\IpmAlcabalaController@totalPages')->name('mantenedores.ipm_alcabala.total_pages');
    Route::get('/lista-mantenedores-ipm-alcabala-list/{id}', 'Mantenedores\IpmAlcabalaController@list')->name('mantenedores.ipm_alcabala.list');
    Route::post('/lista-mantenedores-ipm-alcabala-search', 'Mantenedores\IpmAlcabalaController@listSearch')->name('mantenedores.ipm_alcabala.search');
    Route::post('/store-data-ipm-alcabala', 'Mantenedores\IpmAlcabalaController@storeDataIpmAlcabala')->name('mantenedores.ipm_alcabala.store');
    Route::post('/delete-ipm-alcabala', 'Mantenedores\IpmAlcabalaController@deleteDataIpmAlcabala')->name('mantenedores.ipm_alcabala.delete');
    Route::post('/active-ipm-alcabala', 'Mantenedores\IpmAlcabalaController@activeDataIpmAlcabala')->name('mantenedores.ipm_alcabala.active');
    Route::post('/update-data-ipm-alcabala', 'Mantenedores\IpmAlcabalaController@updateDataIpmAlcabala')->name('mantenedores.ipm_alcabala.update');
    Route::get('/datos-ipm-alcabala-edit/{id}', 'Mantenedores\IpmAlcabalaController@editDataIpmAlcabala')->name('mantenedores.ipm_alcabala.edit');
    Route::get('/lista-anios-ipm-alcabala-text', 'Mantenedores\IpmAlcabalaController@listAniosIpmAlcabala')->name('mantenedores.ipm_alcabala.listAnios');


    //PARAMETROS
    Route::get('/mantenedores-parametros', 'Mantenedores\ParametrosController@index')->name('mantenedores.parametros.index');
    Route::get('/lista-mantenedores-parametros-total-pages', 'Mantenedores\ParametrosController@totalPages')->name('mantenedores.parametros.total_pages');
    Route::get('/lista-mantenedores-parametros-list/{id}', 'Mantenedores\ParametrosController@list')->name('mantenedores.parametros.list');
    Route::post('/lista-mantenedores-parametros-search', 'Mantenedores\ParametrosController@listSearch')->name('mantenedores.parametros.search');
    Route::post('/lista-mantenedores-parametros-search-total', 'Mantenedores\ParametrosController@listSearchTotal')->name('mantenedores.parametros.searchTotal');

    Route::post('/store-data-parametros', 'Mantenedores\ParametrosController@storeDataParametros')->name('mantenedores.parametros.store');
    Route::post('/delete-parametros', 'Mantenedores\ParametrosController@deleteDataParametros')->name('mantenedores.parametros.delete');
    Route::post('/active-parametros', 'Mantenedores\ParametrosController@activeDataParametros')->name('mantenedores.parametros.active');
    Route::post('/update-data-parametros', 'Mantenedores\ParametrosController@updateDataParametros')->name('mantenedores.parametros.update');
    Route::get('/datos-parametros-edit/{id}', 'Mantenedores\ParametrosController@editDataParametros')->name('mantenedores.parametros.edit');
    Route::get('/lista-anios-parametros-text', 'Mantenedores\ParametrosController@listAniosParametros')->name('mantenedores.parametros.listAnios');




    //COMBOS
    Route::get('/lista-general-combos-meses', 'CombosController@meses')->name('general.combos.meses'); // SOLO MESES
    Route::get('/lista-general-combos-meses-todo', 'CombosController@mesesTodos')->name('general.combos.meses.todos'); // MESES TODOS
    Route::get('/lista-tipoclasificacion-arancelrustico-text', '@clasificacionArancelRustico')->name('general.combos.clasificacion.arancel_rustico'); // CLASIFICACION DE ARANCELES RUSTICOS
    Route::get('/lista-tipocategoria-arancelrustico-text', 'CombosController@categoriaArancelRustico')->name('general.combos.categoria.arancel_rustico'); // CATEGORIA DE ARANCELES RUSTICOS


    Route::get('/lista-tributos-grupos-text', 'CombosController@listGrupoTributos')->name('general.combos.tributos.grupo');
    Route::get('/lista-tributos-genericos-text', 'CombosController@lisGenericoTributos')->name('general.combos.tributos.generico');
    Route::get('/lista-tributos-subgenericos-text/{id}', 'CombosController@listSubgenericosTributos')->name('general.combos.tributos.subgenerico');
    Route::get('/lista-tributos-especifica-text/{id}', 'CombosController@listEspecificaTributos')->name('general.combos.tributos.especifica');
    Route::get('/lista-tributos-area-text', 'CombosController@listAreaTributos')->name('general.combos.tributos.area');

    Route::get('/lista-tributos-fuentes-text', 'CombosController@listFuentesTributos')->name('general.combos.tributos.fuentes');






































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
