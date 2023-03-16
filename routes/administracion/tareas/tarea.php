<?php

Route::get('/administracion-tareas', 'Administracion\TareasController@index')->name('administracion.tareas.index');
Route::get('/lista-administracion-tareas-total-pages', 'Administracion\TareasController@totalPages')->name('administracion.tareas.total_pages');
Route::get('/lista-administracion-tareas-list/{id}', 'Administracion\TareasController@list')->name('administracion.tareas.list');
Route::post('/store-data-tareas', 'Administracion\TareasController@storeDataTareas')->name('administracion.tareas.store');
Route::post('/delete-tarea', 'Administracion\TareasController@deleteDataTareas')->name('administracion.tareas.delete');
Route::post('/active-tarea', 'Administracion\TareasController@activeDataTareas')->name('administracion.tareas.active');
Route::get('/datos-tareas-edit/{id}', 'Administracion\TareasController@editDataTareas')->name('administracion.tareas.edit');
Route::post('/update-data-tareas', 'Administracion\TareasController@updateDataTareas')->name('administracion.tareas.update');
Route::post('/lista-administracion-tareas-search', 'Administracion\TareasController@listSearch')->name('administracion.tareas.search');
?>