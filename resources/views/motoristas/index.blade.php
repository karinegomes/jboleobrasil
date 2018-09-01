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
                        <a href="{{ route('motoristas.create') }}" id="adicionar-motorista" class="btn btn-default">
                            <i class="fa fa-plus mr-5"></i> Adicionar
                        </a>
                        <button id="visualizar-motorista" class="btn btn-default motorista-btn" data-url="{{ route('motoristas.show', '__id__') }}" disabled>
                            <span class="fa fa-search"></span> Visualizar
                        </button>
                        <button id="editar-motorista" class="btn btn-default motorista-btn" data-url="{{ route('motoristas.edit', '__id__') }}" disabled>
                            <span class="fa fa-pencil"></span> Editar
                        </button>
                        <button class="btn btn-default motorista-del-btn" disabled>
                            <span class="fa fa-times"></span> Apagar
                        </button>

                        <form method="POST" action="{{ route('motoristas.destroy', '__id__') }}" class="hidden form-excluir-motorista">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
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
            var table = $('#motoristas').DataTable({
                "language": {
                    "lengthMenu": "Exibir _MENU_ resultados",
                    "zeroRecords": "Nenhum resultado encontrado.",
                    "infoEmpty": "Nenhum resultado encontrado.",
                    "infoFiltered": "(filtrado de _MAX_ resultados)",
                    "info": "Exibindo de_START_ à _END_ (Total: _TOTAL_)",
                    "search": "Buscar:",
                    "paginate": {
                        "previous": "«",
                        "next": "»"
                    }
                },
                "ajax": {
                    url: "/ajax/motoristas/table-data"
                },
                "bSortClasses": false,
                "processing": true,
                "serverSide": true,
                "columns": [
                    { "data": "nome" },
                    { "data": "cpf" },
                    { "data": "telefone" },
                    { "data": "celular" },
                    { "data": "placa" },
                    { "data": "tipo_de_caminhao" }
                ],
                'fnRowCallback': function(nRow, aData, iDisplayIndex) {
                    console.log(aData);

                    $(nRow).data('id', aData.id);

                    $(nRow).on('click', function () {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            $('.motorista-btn, .motorista-del-btn').prop('disabled', true);
                        }
                        else {
                            table.$('tr.selected').removeClass('selected')
                            $(this).addClass('selected');
                            $('.motorista-btn, .motorista-del-btn').removeAttr('disabled');
                        }
                    });
                }
            });

            $('.motorista-btn').on('click', function() {
                var id = $('#motoristas .selected').data('id');
                var url = $(this).data('url').replace('__id__', id);

                window.location.href = url;
            });

            $('.motorista-del-btn').on('click', function () {
                var result = confirm("Deseja realmente apagar esse registro?");

                if (result) {
                    var id = $('#motoristas .selected').data('id');
                    var $form = $('.form-excluir-motorista');
                    var url = $form.attr('action').replace('__id__', id);

                    $form.attr('action', url).submit();
                }
            });
        });
    </script>
@endpush