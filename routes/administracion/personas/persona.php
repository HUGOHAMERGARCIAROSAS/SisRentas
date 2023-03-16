<?php
Route::get('/administracion-persona', 'Administracion\PersonaController@index')->name('administracion.persona.index');
Route::get('/lista-administracion-persona-list/{id}', 'Administracion\PersonaController@list')->name('administracion.persona.list');
Route::get('/lista-administracion-persona-total-pages', 'Administracion\PersonaController@totalPages')->name('administracion.persona.total_pages');
Route::post('/lista-administracion-persona-search', 'Administracion\PersonaController@listSearch')->name('administracion.persona.search');
Route::post('/store-data-persona', 'Administracion\PersonaController@storeDataPersona')->name('administracion.persona.store');
Route::post('/delete-persona', 'Administracion\PersonaController@deleteDataPersona')->name('administracion.persona.delete');
Route::post('/active-persona', 'Administracion\PersonaController@activeDataPersona')->name('administracion.persona.active');
Route::get('/datos-persona-edit/{id}', 'Administracion\PersonaController@editDataPersona')->name('administracion.persona.edit');
Route::post('/update-data-persona', 'Administracion\PersonaController@updateDataPersona')->name('administracion.persona.update');
Route::get('/dvalidate-dni-create-person/{id}', 'Administracion\PersonaController@ValidateDniDataPersona')->name('administracion.persona.validate.dni');
?>