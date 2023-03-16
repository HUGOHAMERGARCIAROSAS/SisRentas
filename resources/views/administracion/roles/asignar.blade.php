@extends('layouts.layout')
@section('main')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>PERMISOS</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Asignar</li>
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card"> --}}
                {{-- <div class="body">
                    <form action="{{ route('administracion.roles.usuario.update', $rol[0]->rol_id)}}" method="POST" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="table" >
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"   
                                        class="custom-control-input"  
                                        id="permission_{{$permission->tarea_id}}"
                                        value="{{$permission->tarea_id}}"
                                        name="permission[]"
                                    
                                        @if( is_array(old('permission')) && in_array("$permission->tarea_id", old('permission'))    )
                                        checked
                                    
                                        @elseif( is_array($permission_role) && in_array("$permission->tarea_id", $permission_role)    )
                                        checked
                                    
                                        @endif >
                                        <label class="form-check-label" for="defaultCheck1">
                                        {{$permission->tar_nombre}}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <br><br><br>
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3">
                                    <a href="{{route('administracion.roles.index')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Regresar</a>
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}
            {{-- </div>
        </div>
    </div> --}}
    <div id="app">
        <administracion-roles-asignar></administracion-roles-asignar>
    </div>
</div>
@endsection

