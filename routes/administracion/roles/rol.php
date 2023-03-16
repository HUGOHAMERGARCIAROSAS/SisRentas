<?php
Route::get('/administracion-roles', 'Administracion\RolesController@index')->name('administracion.roles.index');
Route::get('/lista-administracion-roles-total-pages', 'Administracion\RolesController@totalPages')->name('administracion.roles.total_pages');
Route::get('/lista-administracion-roles-list/{id}', 'Administracion\RolesController@list')->name('administracion.roles.list');
Route::post('/store-data-roles', 'Administracion\RolesController@storeDataRoles')->name('administracion.roles.store');
Route::post('/delete-rol', 'Administracion\RolesController@deleteDataRoles')->name('administracion.roles.delete');
Route::post('/active-rol', 'Administracion\RolesController@activeDataRoles')->name('administracion.roles.active');
Route::get('/datos-roles-edit/{id}', 'Administracion\RolesController@editDataRoles')->name('administracion.roles.edit');
Route::post('/update-data-roles', 'Administracion\RolesController@updateDataRoles')->name('administracion.roles.update');
Route::post('/lista-administracion-roles-search', 'Administracion\RolesController@listSearch')->name('administracion.roles.search');
Route::get('/datos-roles-usuario-list/{id}', 'Administracion\RolesController@editDataRolesUsuario')->name('administracion.roles.usuario.edit');
Route::get('/administracion/PermisosRol/{rol}', 'Administracion\RolesController@asignaPermisoRoles')->name('administracion.permisosrol.roles');
Route::put('/update-data-roles/{id}', 'Administracion\RolesController@updateDataAsignarRoles')->name('administracion.roles.usuario.update');
Route::get('/lista-administracion-todos-permisos', 'Administracion\RolesController@totalPermissions')->name('administracion.permission.total');
Route::get('/lista-administracion-todos-permisos-usuario', 'Administracion\RolesController@totalPermissionsUsuario')->name('administracion.permission.usuario.total');
Route::post('/delete-roles-usuario', 'Administracion\RolesController@deleteDataRolesUsuario')->name('administracion.roles_usuario.delete');
Route::post('/active-roles-usuario', 'Administracion\RolesController@activeDataRolesUsuario')->name('administracion.roles_usuario.active');
Route::get('/datos-validate-roles-usuario/{id}/{persona_id}', 'Administracion\RolesController@validateDataRolesUsuario')->name('administracion.roles.usuario.validate');
Route::get('/lista-administracion-grupos-permisos-byGrupo', 'Administracion\RolesController@getGruposPermisosByGrupos')->name('administracion.grupos.permisos.byGrupo');
Route::get('/lista-administracion-permisos-roles-list/{id}', 'Administracion\RolesController@listaPermisosRolesList')->name('administracion.permisos.roles.list');
Route::get('/lista-administracion-permisos-roles-titulo/{id}', 'Administracion\RolesController@listaPermisosRolesTitulo')->name('administracion.permisos.roles.titulo');
Route::post('/update-roles-permisos-actual', 'Administracion\RolesController@updateRolesPermisosActual')->name('administracion.update.permisos.actual');
?>