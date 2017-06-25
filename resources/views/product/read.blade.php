@extends('layouts.app')

@section('entity-label', 'Produto')
@section('entity-url', 'product')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Produto</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/product/'.$product->id.'/edit') }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 col-md-offset-2 control-label"><strong>Nome</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $product->name }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="position" class="col-sm-2 col-md-offset-2 control-label"><strong>Descrição</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $product->description }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 col-md-offset-2 control-label"><strong>Categoria</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $product->category ? $product->category->name : '-' }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Fornecedor</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $product->supplier ? $product->supplier->name : '-' }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Especificações</strong></label>

                            <div class="col-sm-6">
                                @foreach($product->specs as $spec)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-sm-12">
                                            <p class="form-control-static">{{ $spec->name }} - {{ $spec->value }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/morris/morris.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('js/morris/morris.min.js') }}"></script>

    <script type="text/javascript">
        Morris.Line({
            element: 'line-example',
            data: {!! $variations !!},
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Preço'],
            lineColors: ['#16a085']
        });
    </script>
@endpush
