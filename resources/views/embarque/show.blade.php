@extends('layouts.app')

@section('entity-label', 'Visualizar resumo')
@section('entity-url', 'contrato/' . $embarque->contrato_id . '/resumo')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Embarque</h1>
                    {{--<ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/product/'.$product->id.'/edit') }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>--}} {{-- TODO --}}
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 col-md-offset-2 control-label"><strong>Entrega</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->entrega }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="position" class="col-sm-2 col-md-offset-2 control-label"><strong>Nota Fiscal</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->nota_fiscal }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 col-md-offset-2 control-label"><strong>Quantidade</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->quantidade }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Data do embarque</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{  $embarque->dataEmbarqueFormatado() }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Saldo</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->saldo }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Data Pagto. Mercadoria</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->dataPagamentoFormatado() }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 col-md-offset-2 control-label"><strong>Observação</strong></label>

                            <div class="col-sm-6">
                                <p class="form-control-static">{{ $embarque->observacao }}</p>
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