@extends('layouts.app')

@section('entity-label', 'Contrato')
@section('entity-url', 'order')
@section('action-label', 'Listar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Listar</strong> Contratos</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('order.create') }}" class="btn btn-default">
                                <i class="fa fa-plus mr-5"></i> Adicionar
                            </a>
                            <button class="btn btn-default disableable-btn order-btn"
                                    data-url="/order/create?reference_order=__id__"
                                    disabled>
                                <span class="fa fa-files-o"></span> Copiar
                            </button>
                            <button class="btn btn-default disableable-btn order-cancel-btn" disabled>
                                <span class="fa fa-times"></span> Cancelar pedido
                            </button>
                            <button class="btn btn-default disableable-btn order-pdf-btn"
                                    data-url="/order/vendedor/__reference__"
                                    disabled>
                                <span class="fa fa-file-pdf-o"></span> Gerar Contrato - Vendedor
                            </button>
                            <button class="btn btn-default disableable-btn order-pdf-btn"
                                    data-url="/order/comprador/__reference__"
                                    disabled>
                                <span class="fa fa-file-pdf-o"></span> Gerar Contrato - Comprador
                            </button>
                            <button class="btn btn-default disableable-btn order-btn"
                                    data-url="/order/__id__/edit"
                                    disabled>
                                <span class="fa fa-pencil"></span> Editar
                            </button>
                            @if($userId == 1)
                                <button class="btn btn-default disableable-btn order-del-btn" disabled>
                                    <span class="fa fa-trash"></span> Apagar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- tile body -->
                <div class="tile-body p-0">
                    <table id="orders" class="table table-bordered dt-responsive display"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Número</th>
                            <th>Data</th>
                            <th>Vendedor</th>
                            <th>Comprador</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
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
            var table = $('#orders').DataTable({
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
                    url: "/ajax/orders/table-data"
                },
                "bSortClasses": false,
                "processing": true,
                "serverSide": true,
                "columns": [
                    { "data": "reference_code" },
                    { "data": "custom_sell_date" },
                    { "data": "vendedor" },
                    { "data": "comprador" },
                    { "data": "produto" },
                    { "data": "quantidade" },
                    { "data": "preco" },
                    { "data": "status" }
                ],
                'fnRowCallback': function(nRow, aData, iDisplayIndex) {
                    $(nRow).data('id', aData.id);
                    $(nRow).data('reference_code', aData.reference_code);

                    $(nRow).on('click', function () {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                            $('.disableable-btn').prop('disabled', true);
                        }
                        else {
                            table.$('tr.selected').removeClass('selected')
                            $(this).addClass('selected');
                            $('.disableable-btn').removeAttr('disabled');
                        }
                    });
                }
            });

            $('.order-btn').on('click', function() {
                var id = $('#orders .selected').data('id');

                window.location.href = $(this).data('url').replace('__id__', id);
            });

            $('.order-cancel-btn').on('click', function () {
                $('.alert').remove();

                var id = $('#orders .selected').data('id');
                var $this = $(this);

                if (confirm("Deseja realmente cancelar esse pedido?")) {
                    $.ajax({
                        url: '/contrato/'+id+'/cancelar',
                        data: { _token: '{{ csrf_token() }}' },
                        type: 'POST',
                        success: function(result) {
                            $('.pageheader').after('<div class="alert alert-success">\
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                                              ' + result + '\
                                            </div>');

                            $('#orders .selected').find('td').eq(7).text('Cancelado');
                        },
                        error: function(response) {
                            $('.pageheader').after('<div class="alert alert-danger">\
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                                              ' + response.responseJSON + '\
                                            </div>');
                        }
                    });
                }
            });

            $('.order-pdf-btn').on('click', function () {
                var refCode = $('#orders .selected').data('reference_code').replace('/', '-');
                var url = $(this).data('url').replace('__reference__', refCode);

                window.open(url, '_blank');
            });

            $('.order-del-btn').on('click', function () {
                var result = confirm("Deseja realmente apagar esse contrato?");
                var id = $('#orders .selected').data('id');

                if(result){
                    $.ajax({
                        url: '/order/' + id,
                        data: { _token: '{{ csrf_token() }}' },
                        type: 'DELETE',
                        success: function(result) {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush