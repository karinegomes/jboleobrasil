@extends('layouts.app')

@section('entity-label', 'Pós-Venda')
@section('entity-url', 'pos-venda')
@section('action-label', 'Controle de Pagamento')

@section('content')
    <div class="alert alert-danger hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>

    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Controle</strong> de Pagamento - {{ $nomeEmpresa }}</h1>
                    {{--<ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/finance/'.$filter_id) }}">
                                <span class="fa fa-file-text mr-5"></span> Gerar Comissão
                            </a>
                        </li>
                    </ul>--}}
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-12">
                            <button @click="incluir_baixa" class="btn btn-default" :disabled="!selected || selected.status == 'pago'">
                                <span class="fa fa-plus mr-5"></span> Incluir baixa
                            </button>
                            <button @click="editar_baixa" class="btn btn-default" :disabled="!selected || selected.status == 'nao_pago'">
                                <span class="fa fa-pencil mr-5"></span> Editar baixa
                            </button>
                            <button @click="excluir_baixa" class="btn btn-default" :disabled="!selected || selected.status == 'nao_pago'">
                                <span class="fa fa-trash mr-5"></span> Excluir baixa
                            </button>
                        </div>
                    </div>
                </div>
                <!-- tile body -->
                <div class="tile-body p-0">
                    <demo-grid
                            :data="gridData"
                            :selected.sync="selected"
                            :columns="gridColumns"
                            :filter-key="searchQuery">
                    </demo-grid>
                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection

@push('components')
@include('components.grid')
@endpush

{{--@push('styles')
<link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush--}}

@push('scripts')
{{--<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>--}}

<script type="text/javascript">
    /*$('.data').datetimepicker({
        format: 'DD/MM/YYYY',
        showTodayButton: true
    });*/

    new Vue({
        el: '#grid',
        data: {
            selected: null,
            searchQuery: '',
            gridData: JSON.parse('{!! $embarques !!}'),
            gridColumns: [
                { key: 'contrato', label: 'Contrato' },
                { key: 'vendedor', label: 'Vendedor' },
                { key: 'comprador', label: 'Comprador' },
                { key: 'produto', label: 'Produto' },
                { key: 'preco', label: 'Preço' },
                { key: 'porcentagemComissao', label: '% Comissão' },
                { key: 'notaFiscal', label: 'NF Cliente' },
                { key: 'quantidade', label: 'Quantidade' },
                { key: 'emissaoNF', label: 'Emissão NF' },
                { key: 'vencimentoNF', label: 'Vencimento NF' },
                { key: 'comissao', label: 'Comissão' },
                { key: 'observacao', label: 'Obs' }
            ]
        },
        methods: {
            incluir_baixa: function() {
                const idEmbarque = this.selected.id;
                const idCliente = this.selected.idCliente;

                location.href = '{{ url('pos-venda') }}/' + idCliente + '/controle-pagamento/' + idEmbarque + '/baixa/criar';
            },
            editar_baixa: function() {
                const idEmbarque = this.selected.id;
                const idCliente = this.selected.idCliente;

                location.href = '{{ url('pos-venda') }}/' + idCliente + '/controle-pagamento/' + idEmbarque + '/baixa/editar';
            },
            excluir_baixa: function() {
                const idBaixa = this.selected.idBaixa;
                const idCliente = this.selected.idCliente;

                const r = confirm("Tem certeza que deseja excluir a baixa?");

                if (r == true) {
                    $.ajax({
                        type: "DELETE",
                        url: APP_URL + '/baixa/' + idBaixa,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            location.href = '{{ url('pos-venda') }}/' + idCliente + '/controle-pagamento/' + result.inicio_mes + '/' + result.final_mes;
                        },
                        error: function(response, textStatus, errorThrown) {
                            var error = response.responseJSON;

                            $('.alert-danger').append('<span>' + error + '</span>');
                            $('.alert-danger').removeClass('hidden');
                        }
                    });
                }
            }
        }
    });
</script>
@endpush
