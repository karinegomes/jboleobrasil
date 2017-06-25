@extends('layouts.app')

@section('entity-label', 'Contato')
@section('entity-url', 'client')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Contato</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/client/'.$client->id.'/edit') }}">
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
                            <label for="name" class="col-sm-2 control-label">Nome</label>

                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $client->name }}</p>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="position" class="col-sm-2 control-label">Cargo</label>

                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $client->position }}</p>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">E-mail</label>

                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $client->email }}</p>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Empresa</label>

                            <div class="col-sm-10">
                                <address>
                                    <strong>{{ $client->company->name }}</strong><br>
                                    {{ $client->company->address->name }}, {{ $client->company->address->number }} -
                                    {{ $client->state_name }}<br>
                                    CEP {{ $client->company->address->zip_code }}
                                </address>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Telefones</label>

                            <div class="col-sm-1">
                                <p class="form-control-static">{{ $client->ddd }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p class="form-control-static">{{ $client->number }}</p>
                            </div>
                            <div class="col-sm-3">
                                <p class="form-control-static">Ramal {{ $client->extesion }}</p>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
        <div class="col-md-8">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Anotações</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" data-toggle="modal" data-target="#notesModal">
                                <span class="fa fa-pencil-square mr-5"></span> Nova Anotação
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <div class="list-group">
                        @foreach($client->interactions as $note)
                            <div class="list-group-item">
                                <h5 class="list-group-item-heading">{{$note->description}}</h5>

                                <p class="list-group-item-text text-strong">{{ "{$note->type} em {$note->accomplished_at} por {$note->user_name}" }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        <!-- /col -->
    </div>
@endsection
@push('snippets')
<div class="modal fade" id="notesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Nova Anotação</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="note" action="{{ url('/interaction') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Tipo de Anotação</label>

                        <div class="col-sm-10">
                            <select class="form-control mb-10" name="type">
                                <option value="realizada">Contato realizado</option>
                                <option value="remarcada">Contato remarcado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Observação</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" name="description"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="note" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i>
                    Submit
                </button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i
                            class="fa fa-arrow-left"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endpush
