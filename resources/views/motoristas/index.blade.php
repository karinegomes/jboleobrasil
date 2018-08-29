@extends('layouts.app')

@section('entity-label', 'Motoristas')
@section('entity-url', 'motoristas')
@section('action-label', 'Listar')

@section('content')
    <section class="tile">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font"><strong>Motoristas</strong></h1>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">
            <div class="tile-widget">
                <div class="row">
                    <div class="col-md-12">
                        <button id="visualizar-motorista" class="btn btn-default" disabled>
                            <span class="fa fa-search"></span> Visualizar
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="motoristas" class="table table-bordered dt-responsive display"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>Placa</th>
                            <th>Tipo de caminhão</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($motoristas as $motorista)
                            <tr data-id="{{ $motorista->id }}">
                                <td>{{ $motorista->nome }}</td>
                                <td>{{ $motorista->cpf }}</td>
                                <td>{{ $motorista->telefone }}</td>
                                <td>{{ $motorista->celular }}</td>
                                <td>{{ $motorista->placa }}</td>
                                <td>{{ $motorista->tipoDeCaminhao ? $motorista->tipoDeCaminhao->nome : '' }}</td>
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