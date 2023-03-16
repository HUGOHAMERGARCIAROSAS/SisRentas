<?php
Route::get('/administracion-grupos', 'Administracion\GruposController@index')->name('administracion.grupos.index');
Route::get('/lista-administracion-grupos-total-pages', 'Administracion\GruposController@totalPages')->name('administracion.grupos.total_pages');
Route::get('/lista-administracion-grupos-list/{id}', 'Administracion\GruposController@list')->name('administracion.grupos.list');
Route::post('/store-data-grupos', 'Administracion\GruposController@storeDataGrupos')->name('administracion.grupos.store');
Route::post('/delete-grupo', 'Administracion\GruposController@deleteDataGrupos')->name('administracion.grupos.delete');
Route::post('/active-grupo', 'Administracion\GruposController@activeDataGrupos')->name('administracion.grupos.active');
Route::get('/datos-grupos-edit/{id}', 'Administracion\GruposController@editDataGrupos')->name('administracion.grupos.edit');
Route::post('/update-data-grupos', 'Administracion\GruposController@updateDataGrupos')->name('administracion.grupos.update');
Route::post('/lista-administracion-grupos-search', 'Administracion\GruposController@listSearch')->name('administracion.grupos.search');
Route::get('/lista-administracion-grupos-permisos', 'Administracion\GruposController@listGruposPermisos')->name('administracion.grupos_permisos.list');
?>