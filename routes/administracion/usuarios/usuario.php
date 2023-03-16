<?php
Route::get('/administracion-usuario', 'Administracion\UsuarioController@index')->name('administracion.usuario.index');
Route::get('/lista-administracion-usuario-list/{id}', 'Administracion\UsuarioController@list')->name('administracion.usuario.list');
Route::get('/lista-administracion-usuario-total-pages', 'Administracion\UsuarioController@totalPages')->name('administracion.usuario.total_pages');
Route::post('/lista-administracion-usuario-search', 'Administracion\UsuarioController@listSearch')->name('administracion.usuario.search');
Route::post('/store-data-usuario', 'Administracion\UsuarioController@storeDataUsuario')->name('administracion.usuario.store');
Route::post('/delete-usuario', 'Administracion\UsuarioController@deleteDataUsuario')->name('administracion.usuario.delete');
Route::post('/active-usuario', 'Administracion\UsuarioController@activeDataUsuario')->name('administracion.usuario.active');
Route::get('/datos-usuario-edit/{id}', 'Administracion\UsuarioController@editDataUsuario')->name('administracion.usuario.edit');
Route::post('/update-data-usuario', 'Administracion\UsuarioController@updateDataUsuario')->name('administracion.usuario.update');
Route::get('/datos-usuario-edit-password/{id}', 'Administracion\UsuarioController@editDataUsuarioPassword')->name('administracion.usuario.edit.password');
Route::post('/update-data-usuario-password', 'Administracion\UsuarioController@updateDataUsuarioPassword')->name('administracion.usuario.update.password');
Route::post('/store-data-roles-usuario', 'Administracion\UsuarioController@updateDataRolesUsuario')->name('administracion.roles_usuario.store');
?>