<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" content="{{ csrf_token() }}">

    <title>@yield('entity-label', 'Dashboard') - JBOleoBrasil</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <script>
        var APP_URL = '{{ url('/') }}';
    </script>
</head>
<body id="app-layout" class="appWrapper hz-menu aside-fixed black-scheme-color scheme-black">
<section id="header" class="scheme-black">
    <header class="clearfix">
        <!-- Branding -->
        <div class="branding scheme-black">
            <a href="{{ url('/') }}" class="brand">
                <span><strong>JB</strong>OleoBrasil</span>
            </a>
            <a href="#" class="offcanvas-toggle visible-xs-inline"><i class="fa fa-bars"></i></a>
        </div>
        <!-- Branding end -->
        @if (!Auth::guest())
            <ul class="nav-right pull-right list-inline">
                <li class="dropdown nav-profile">
                    <a href class="dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul class="dropdown-menu animated littleFadeInRight" role="menu">
                        <li>
                            <a href="{{url('/user/'.Auth::user()->id.'/edit')}}">
                                <i class="fa fa-edit"></i>Alterar Dados
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('/logout') }}">
                                <i class="fa fa-sign-out"></i>Sair
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
                    <!-- Right-side navigation end -->
    </header>
</section>
@if (!Auth::guest())
        <!-- =================================================
  ================= CONTROLS Content ===================
  ================================================== -->
<div id="controls">
    <!-- ================================================
    ================= SIDEBAR Content ===================
    ================================================= -->
    <aside id="sidebar" class="aside-fixed scheme-black">
        <div id="sidebar-wrap">
            <div class="panel-group slim-scroll" role="tablist">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#sidebarNav">
                                Navigation <i class="fa fa-angle-up"></i>
                            </a>
                        </h4>
                    </div>
                    <div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            <!-- ===================================================
                            ================= NAVIGATION Content ===================
                            ==================================================== -->
                            <ul id="navigation">
                                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> <span>Home</span></a></li>
                                <li><a href="{{url('/agenda')}}"><i class="fa fa-phone"></i> <span>Agenda</span></a>
                                </li>
                                <li><a href="{{url('/company')}}"><i class="fa fa-industry"></i>
                                        <span>Clientes</span></a></li>
                                <li><a href="{{url('/product')}}"><i class="fa fa-truck"></i> <span>Produtos</span></a>
                                </li>
                                <li><a href="{{url('/order')}}"><i class="fa fa-file-text"></i>
                                        <span>Contratos</span></a></li>
                                <li>
                                    <a href="{{url('/embarques')}}"><i class="fa fa-usd"></i> <span>Embarques</span></a>
                                </li>
                                <li>
                                    <a href="{{ url('pos-venda') }}">
                                        <i class="fa fa-money"></i> <span>Comissão</span>
                                    </a>
                                </li>
                                <li><a href="{{url('/appointment')}}"><i class="fa fa-calendar-o"></i>
                                        <span>Compromissos</span>
                                        @if(count($appointments) > 0)
                                            <span class="badge bg-lightred">{{count($appointments)}}</span>
                                        @endif
                                    </a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><a href="{{url('/user')}}"><i class="fa fa-users"></i> Usuários</a></li>
                                    <li>
                                        <a href="#"><i class="fa fa-wrench"></i> <span>Configurações</span></a>
                                        <ul>
                                            <li><a href="{{url('/category')}}"><i class="fa fa-caret-right"></i>
                                                    Categorias</a></li>
                                            <li><a href="{{url('/package')}}"><i class="fa fa-caret-right"></i>
                                                    Embalagens</a></li>
                                            <li><a href="{{url('/group')}}"><i class="fa fa-caret-right"></i> Tipos de
                                                    Cliente</a></li>
                                            <li><a href="{{url('/incoterm')}}"><i class="fa fa-caret-right"></i>
                                                    Incoterms</a></li>
                                            <li><a href="{{url('/measure')}}"><i class="fa fa-caret-right"></i> Unidades
                                                    de Medida</a></li>
                                            <li><a href="{{url('/doctype')}}"><i class="fa fa-caret-right"></i> Tipos de
                                                    Documentos</a></li>
                                            <li><a href="{{url('/carrier')}}"><i class="fa fa-caret-right"></i>
                                                    Operadoras</a></li>
                                            <li>
                                                <a href="{{ url('periodo-cobranca') }}">
                                                    <i class="fa fa-caret-right"></i> Períodos de cobrança
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                            <!--/ NAVIGATION Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!--/ SIDEBAR Content -->
</div>
<!--/ CONTROLS Content -->
@endif
<section id="content">
    <div class="page page-hz-menu-layout">
        <div class="pageheader">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="{{url('/')}}/@yield('entity-url', 'home')">@yield('entity-label', 'Dashboard')</a>
                    </li>
                    <li>
                        <a>@yield('action-label', 'Dados')</a>
                    </li>
                </ul>
            </div>
        </div>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>
</section>
<!-- JavaScripts -->
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment/moment.min.js') }}"></script>
@stack('snippets')
@stack('components')
@stack('scripts')
<script type="text/javascript">
    const appointments = {!! $appointments !!};
    var ignore_ids = [];
    var notifications_list = [];

    console.log(appointments);
</script>
<script type="text/javascript" src="{{ asset('js/notification.js') }}"></script>
</body>
</html>
