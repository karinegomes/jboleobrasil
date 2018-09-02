@extends('layouts.app')

@section('entity-label', 'Ordens de Frete')
@section('entity-url', 'ordens-frete')
@section('action-label', 'Listar')

@section('content')
    <section class="tile">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font"><strong>Ordens de Frete</strong></h1>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">
            <div class="tile-widget">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('ordens-frete.create') }}" id="adicionar-ordem-frete" class="btn btn-default">
                            <i class="fa fa-plus mr-5"></i> Adicionar
                        </a>
                        <button id="visualizar-ordem-frete" class="btn btn-default ordem-frete-btn" data-url="{{ route('ordens-frete.show', '__id__') }}" disabled>
                            <span class="fa fa-search"></span> Visualizar
                        </button>
                        <button id="editar-ordem-frete" class="btn btn-default ordem-frete-btn" data-url="{{ route('ordens-frete.edit', '__id__') }}" disabled>
                            <span class="fa fa-pencil"></span> Editar
                        </button>
                        <button class="btn btn-default ordem-frete-del-btn" disabled>
                            <span class="fa fa-times"></span> Apagar
                        </button>

                        <form method="POST" action="{{ route('ordens-frete.destroy', '__id__') }}" class="hidden form-excluir-ordem-frete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="ordens-frete" class="table table-bordered dt-responsive display"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Motorista</th>
                            <th>Data do carregamento</th>
                            <th>Previsão de descarga</th>
                            <th>Valor do frete</th>
                            <th>Cidade de origem</th>
                            <th>Cidade de destino</th>
                            <th>Adiantamento</th>
                            <th>Saldo</th>
                            <th>Status</th>
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
    <script type="text/javascript" src="{{ asset('js/moment/moment.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#ordens-frete').DataTable({
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
                    url: "/ajax/ordens-frete/table-data"
                },
                "bSortClasses": false,
                "processing": true,
                "serverSide": true,
                "columns": [
                    { "data": "motorista" },
                    {
                        "data": "data_carregamento",
                        "render": function ( data, type, row ) {
                            return moment(data).format('DD/MM/YYYY');
                        }
                    },
                    {
                        "data": "previsao_descarga",
                        "render": function ( data, type, row ) {
                            return moment(data).format('DD/MM/YYYY');
                        }
                    },
                    {
                        "data": "valor_frete",
                        "render": function ( data, type, row ) {
                            data = parseFloat(data);

                            return data.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'});
                        }
                    },
                    { "data": "cidade_origem" },
                    { "data": "cidade_destino" },
                    {
                        "data": "adiantamento",
                        "render": function ( data, type, row ) {
                            var valorFrete = parseFloat(row.valor_frete);
                            var adiantamento = parseFloat(data);
                            var valorAdiantamento = valorFrete * (adiantamento/100);

                            return valorAdiantamento.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'}) + ' (' + adiantamento + '%)';
                        }
                    },
                    {
                        "data": "saldo",
                        "render": function ( data, type, row ) {
                            var valorFrete = parseFloat(row.valor_frete);
                            var saldo = parseFloat(data);
                            var valorSaldo = valorFrete * (saldo/100);

                            return valorSaldo.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'}) + ' (' + saldo + '%)';
                        }
                    },
                    { "data": "status" }
                ],
                'fnRowCallback': function(nRow, aData, iDisplayIndex) {
                    $(nRow).data('id', aData.id);

                    $(nRow).on('click', function () {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            $('.ordem-frete-btn, .ordem-frete-del-btn').prop('disabled', true);
                        }
                        else {
                            table.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                            $('.ordem-frete-btn, .ordem-frete-del-btn').removeAttr('disabled');
                        }
                    });
                }
            });

            $('.ordem-frete-btn').on('click', function() {
                var id = $('#ordens-frete .selected').data('id');
                var url = $(this).data('url').replace('__id__', id);

                window.location.href = url;
            });

            $('.ordem-frete-del-btn').on('click', function () {
                var result = confirm("Deseja realmente apagar esse registro?");

                if (result) {
                    var id = $('#ordens-frete .selected').data('id');
                    var $form = $('.form-excluir-ordem-frete');
                    var url = $form.attr('action').replace('__id__', id);

                    $form.attr('action', url).submit();
                }
            });
        });
    </script>
@endpush