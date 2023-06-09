@extends('layouts.layout')
@section('main')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Persona</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Listado</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="app">
        <administracion-persona-inicio></administracion-persona-inicio>
    </div>
</div>
@endsection