<?php
//TIPO PERSONA
Route::get('/lista-tipopersona-text','Administracion\PersonaController@tipoPersona')->name('tipos_persona.list');
//TIPO DOCUMENTO
Route::get('/lista-tipodocumento-text','Administracion\PersonaController@tipoDocumento')->name('tipos_documento.list');
//DEPARTAMENTO
Route::get('/lista-tipodepartamento-text','Administracion\PersonaController@tipoDepartamento')->name('tipos_departamento.list');
//PROVINCIA
Route::get('/lista-tipoprovincia-text/{id}','Administracion\PersonaController@tipoProvincia')->name('tipos_provincia.list');
//DISTRITO
Route::get('/lista-tipodistrito-text/{id}','Administracion\PersonaController@tipoDistrito')->name('tipos_distrito.list');
//JUNTA
Route::get('/lista-tipojunta-text/{id}','Administracion\PersonaController@tipoJunta')->name('tipos_junta.list');
//JUNTA
Route::get('/lista-tipocalle-text/{id}','Administracion\PersonaController@tipoCalle')->name('tipos_calle.list');
//SEXO
Route::get('/lista-tiposexo-text','Administracion\PersonaController@tipoSexo')->name('tipos_sexo.list');
//AREAS
Route::get('/lista-areas-text','Administracion\PersonaController@tipoAreas')->name('tipos_areas.list');
//BUSCAR PERSONA
Route::post('/lista-administracion-persona-select-search', 'Administracion\PersonaController@selectPersonSearch')->name('administracion.persona.select.search');
//TIPO EXPEDIENTE
Route::get('/lista-tipo_expediente-text','Administracion\PersonaController@tipoExpediente')->name('tipos_expedientes.list');
//TIPO TRAMITE
Route::get('/lista-tipo_tramite-text','Administracion\PersonaController@tipoTramite')->name('tipos_tramites.list');
//TIPO ROLES
Route::post('/lista-administracion-roles-select-search', 'Administracion\PersonaController@tipoRoles')->name('administracion.roles.select.search');
//TIPO GRUPOS
Route::get('/lista-tipogrupo-text','Administracion\PersonaController@tipoGrupo')->name('tipos_grupo.list');

//  VALIDACIONES
Route::get('/valida-exists-persona/{id}','Administracion\PersonaController@validacionPersona')->name('validacion_persona.list');

//TIPO LADO ARANCEL
Route::get('/lista-tipolado-text','Administracion\PersonaController@tipoLados')->name('tipos_lados.list');

// TIPO JUNTA ARANCEL
Route::get('/lista-tipojunta-text','Administracion\PersonaController@tipoJuntas')->name('tipos_juntos.list');


?>