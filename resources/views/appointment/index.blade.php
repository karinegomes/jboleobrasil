@extends('layouts.app')

@section('entity-label', 'Compromisso')
@section('entity-url', 'appointment')
@section('action-label', 'Listar')

@section('content')
    <section class="tile">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font"><strong>Compromissos</strong></h1>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <form class="form-inline" role="form" action="{{ url('appointment/filter') }}" method="GET">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <select class="form-control" id="clientes" name="cliente">
                                <option value="todos">Todos</option>
                                @foreach($clientes as $_cliente)
                                    <option value="{{ $_cliente->id }}" {{ isset($cliente) && $_cliente->id == $cliente->id ? 'selected' : '' }}>{{ $_cliente->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $dataInicial }}" id="data-inicial"
                                   placeholder="Data inicial" name="data_inicial">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $dataFinal }}" placeholder="Data final"
                                   id="data-final" name="data_final">
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                </div>
            </div>

            <hr class="line-dashed line-full">

            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <h4>Exibindo compromissos de {{ $dataInicial }} até {{ $dataFinal }} {{ isset($cliente) && $cliente != null ? ' - ' . $cliente->name : '' }}</h4>
                </div>
            </div>

            <div class="tile-widget">
                <div class="row">
                    <div class="col-md-12">
                        <button id="visualizar-compromisso" class="btn btn-default" disabled>
                            <span class="fa fa-search"></span> Visualizar
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="compromissos" class="table table-bordered dt-responsive display"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Descrição do compromisso</th>
                            <th>Situação</th>
                            <th>Anotação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $appointment)
                            <tr data-id="{{ $appointment->id }}">
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>{{ $appointment->name }}</td>
                                <td>{{ $appointment->status->name }}</td>
                                <td>{{ isset($appointment->interaction) ? $appointment->interaction->description : '' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /tile body -->

    </section>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('js/datatables/datatables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/datatables/css/jquery.dataTables.min.css') }}">
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('js/datatables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datatables/extensions/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.date.extensions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/jquery.inputmask.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#compromissos').DataTable({
            "language": {
                "lengthMenu": "Exibir _MENU_ resultados",
                "zeroRecords": "Nenhum resultado encontrado.",
                "infoEmpty": "Nenhum resultado encontrado.",
                "infoFiltered": "(filtrado de _MAX_ resultados)",
                "info": "Exibindo de_START_ à _END_ (Total: _TOTAL_)",
                "search": "Buscar:",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                }
            },
            "bSortClasses": false
        });

        $('#compromissos tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $('#visualizar-compromisso').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#visualizar-compromisso').removeAttr('disabled');
            }
        });

        $('#visualizar-compromisso').on('click', function() {
            var id = $('#compromissos .selected').data('id');

            window.location.href = APP_URL + '/appointment/' + id;
        });

        $('#data-inicial, #data-final').inputmask('d/m/y');
    });
</script>
@endpush
