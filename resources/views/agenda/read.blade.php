@extends('layouts.app')

@section('entity-label', 'Cliente')
@section('entity-url', 'company')
@section('action-label', 'Visualizar')

@section('content')
    @include('include.message')

    @include('include.error')

    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Cliente</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/company/'.$company->id.'/edit') }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body form-horizontal">
                    @include('include.dados_cliente')
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>

    @include('agenda.include.contatos_atrelados')

    <div class="row">
        <div class="col-md-8">
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
                    <div class="list-group" style="overflow: auto; max-height: 237px;">
                        @foreach($company->interactions as $note)
                            <div class="list-group-item">
                                <div class="control-anotacao">
                                    <form class="form-inline" action="{{ url('interaction/' . $note->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input name="_method" value="DELETE" type="hidden">
                                        <button type="submit" class="btn btn-default btn-sm">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </form>
                                </div>
                                <h5 class="list-group-item-heading">{{$note->description}}</h5>

                                <p class="list-group-item-text text-strong">{{ "{$note->created_at} por {$note->user_name}" }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Compromissos</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <div class="list-group" style="overflow: auto; max-height: 237px;">
                        @foreach($company->appointments as $apt)
                            <div class="list-group-item">
                                <div class="control-anotacao">
                                    <form class="form-inline" action="{{ url('appointment/' . $apt->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input name="_method" value="DELETE" type="hidden">
                                        <button type="submit" class="btn btn-default btn-sm">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </form>
                                </div>
                                <h5 class="list-group-item-heading"><a href="{{ url('appointment/' . $apt->id) }}">{{$apt->name}}</a></h5>

                                <p class="list-group-item-text text-strong">{{$apt->date}} {{($apt->time)?"às {$apt->time}":''}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
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
                    {{ csrf_field() }}
                    <input type="hidden" name="company_id" value="{{ $company->id }}">

                    <div class="form-group">

                        <div class="col-sm-2"></div>

                        <div class="col-sm-10">
                            <strong>Remarcar contato</strong>
                        </div>
                    </div>
                    <div class="form-group" id="appointment_date">
                        <label for="inputEmail3" class="col-sm-2 control-label">Remarcar</label>

                        <div class="col-sm-5">
                            <div class="input-group date">
                                <input type="text" name="appointment[date]" class="form-control"
                                       min="{{ date('Y-m-d') }}" id="data-anotacao" placeholder="Data">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="appointment[time]" class="form-control mb-10" id="hora-anotacao" placeholder="Hora">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Observação</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" name="interaction[description]"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button form="note" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i>
                    Salvar
                </button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i
                            class="fa fa-arrow-left"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('components')
@include('components.grid')
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.date.extensions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mask/jquery.mask.js') }}"></script>

<script type="text/javascript">
    $(window).load(function () {
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY',
            showTodayButton: true
        });

        $('#hora-anotacao').inputmask('h:s');
    });
</script>
@endpush
