@extends('layouts.app')

@section('entity-label', 'Motoristas')
@section('entity-url', 'motoristas')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Motorista</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ route('motoristas.edit', $motorista) }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body form-horizontal">
                    @include('motoristas.includes.dados_motorista')
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>

    @include('motoristas.includes.ordens_frete')

    @include('motoristas.includes.visualizar_documentos')

    <input type="hidden" class="motorista_id" value="{{ $motorista->id }}">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/datatables/datatables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/datatables/css/jquery.dataTables.min.css') }}">
@endpush

@push('components')
    @include('components.grid')
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables/extensions/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment/moment.min.js') }}"></script>

    <script type="text/javascript">
        new Vue({
            el: '#grid',
            data: {
                selected: null,
                showModal: false,
                searchQuery: '',
                gridData: {!! $motorista->documents !!},
                gridColumns: [
                    { key: 'name', label: 'Nome' },
                    { key: (entry) => entry.doctype.name, label: 'Tipo de Documento' },
                    { key: (entry) => (new Date(entry.created_at)).toLocaleDateString(), label: 'Inserido em' }
                ]
            },
            methods: {
                read: function(){
                    window.open(`{{ url('/document') }}/${this.selected.id}`, '_blank');
                },
                remove: function(){
                    let result = confirm("Deseja realmente apagar esse registro?");

                    if(result){
                        $.ajax({
                            url: `{{ url('/document') }}/${this.selected.id}`,
                            data: { _token: '{{ csrf_token() }}' },
                            type: 'DELETE',
                            success: function(result) {
                                location.reload();
                            }
                        });
                    }
                }
            }
        });

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
                    url: "/ajax/ordens-frete/table-data",
                    data: {
                        motorista_id: $('.motorista_id').val(),
                    }
                },
                "bSortClasses": false,
                "processing": true,
                "serverSide": true,
                "columns": [
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
                            $('.ordem-frete-btn').prop('disabled', true);
                        }
                        else {
                            table.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                            $('.ordem-frete-btn').removeAttr('disabled');
                        }
                    });
                }
            });

            $('.ordem-frete-btn').on('click', function() {
                var id = $('#ordens-frete .selected').data('id');
                var url = $(this).data('url').replace('__id__', id);

                window.location.href = url;
            });
        });
    </script>
@endpush