<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{asset('user.png')}}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Bienvenido,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{auth()->user()->persona->nombres}} {{auth()->user()->persona->paterno}}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{route('home')}}"><i class="icon-user"></i>Mi Perfil</a></li>
                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Mensajes</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Ajustes</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power"></i>Salir</a></li>
                </ul>
            </div>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        @foreach($grupos as $value)
                        <li class="active">
                            @if(count($value->tareas)>0)
                            <a href="#Dashboard" class="has-arrow"><i class="{{$value->gru_icono}}"></i> <span>{{$value->gru_nombre}}</span></a>
                            <ul>
                                @foreach ($value->tareas as $itemx)
                                    @can('haveaccess',$itemx->tar_url)
                                    <li><a href="{{route($itemx->tar_url)}}">{{$itemx->tar_nombre}}</a></li>
                                    @endcan
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    {{ csrf_field() }}
</form>
