@extends('layouts.app')

@section('entity-label', 'Pós Venda')
@section('entity-url', 'pos-venda')
@section('action-label', 'Listar')

@section('content')
    <div class="alerts"></div>

    <div class="alert alert-success hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span></span>
    </div>

    <div class="alert alert-danger hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span></span>
    </div>

    <div class="row" id="grid">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile mb-0">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm comissao">
                    <h1 class="custom-font mr-20" style="vertical-align: middle"><strong>Gerar</strong> Comissão</h1>

                    <a href="#search-panel" data-toggle="collapse" class="btn btn-default">
                        Filtrar
                    </a>

                    {{--<a href="#controle-comissao-panel" data-toggle="collapse" class="btn btn-default">
                        Controle de comissão
                    </a>--}}

                    <a href="#resumo-pagtos-panel" data-toggle="collapse" class="btn btn-default">Resumo de pagamentos</a>
                </div>
                <!-- /tile header -->
                <div class="tile-widget" style="padding: 0">
                    @include('pos_venda.includes.panel_filtrar')

                    @include('pos_venda.includes.panel_resumo_pagamentos')

                    @include('pos_venda.includes.panel_controle_comissao')

                    @if(isset($nomePeriodo))
                        <h3 class="bb-color p-15 m-0">{{ $nomePeriodo }}</h3>
                    @endif
                </div>

                <div class="tile-body p-0 grid-comissao">
                    <comissao-grid
                        :periodos="periodos"
                        :periodoSelecionado.sync="periodoSelecionado"
                        :clientes.sync="clientes"
                        :colunas-clientes="colunasClientes"
                        :embarques="embarques"
                        :colunas-embarques="colunasEmbarques"
                        :embarqueSelecionado="embarqueSelecionado">
                    </comissao-grid>
                </div>

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection

@push('components')
    @include('pos_venda.includes.grid_comissao')
@endpush

@push('snippets')
    @include('pos_venda.includes.modal_cobranca_periodo')
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>

<script type="text/javascript">
    $('.data').datetimepicker({
        format: 'DD/MM/YYYY',
        showTodayButton: true,
        widgetPositioning: {
            vertical: 'bottom'
        }
    });

    console.log({!! $intervalosEmbarques !!} );

    const vue = new Vue({
        el: '#app-layout',
        data: { // TODO: Apagar o q n for usado
            selected: null,
            searchQuery: '',
            gridData: null,
            gridColumns: [
                { key: 'codigo', label: 'Código' },
                { key: 'nome_fantasia', label: 'Empresa' }
            ],
            minDate: '{{ $filtro['min_date'] }}',
            maxDate: '{{ $filtro['max_date'] }}',
            vendedor: '{{ $filtro['vendedor'] != '' ? $filtro['vendedor'] : 'todos' }}',
            comprador: '{{ $filtro['comprador'] != '' ? $filtro['comprador'] : 'todos' }}',
            intervalo: null,
            intervaloResumo: null,
            controleComissaoURL: '#',
            nome: null,
            periodos: {!! $intervalosEmbarques !!},
            periodoSelecionado: null,
            clientes: null,
            colunasClientes: [
                { key: 'codigo', label: 'Código' },
                { key: 'nome_fantasia', label: 'Empresa' }
            ],
            embarques: null,
            colunasEmbarques: [
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
                { key: 'valorPago', label: 'Valor pago'},
                { key: 'observacao', label: 'Obs' }
            ],
            embarqueSelecionado: null
        },
        methods: {
            salvarCobranca: function() {
                const _this = this;

                $.ajax({
                    type: "POST",
                    url: APP_URL + '/pos-venda/salvar-periodo',
                    data: {
                        _token: '{{ csrf_token() }}',
                        min_date: _this.minDate,
                        max_date: _this.maxDate,
                        nome: _this.nome
                    },
                    success: function(msg) {
                        console.log(msg);
                        $('#modal-cobranca-periodo').modal('hide');

                        var $clone = $('.alert-success').clone();

                        $clone.find('span').text(msg);
                        $('.alerts').append($clone);
                        $clone.removeClass('hidden');

                        location.reload();
                    },
                    error: function(response, textStatus, errorThrown) {
                        console.log(response);

                        $('#modal-cobranca-periodo').modal('hide');

                        var $clone = $('.alert-danger').clone();

                        if(response.status == 422) {
                            var lis = '';

                            for (var key in response.responseJSON) {
                                if (response.responseJSON.hasOwnProperty(key)) {
                                    for(var i in response.responseJSON[key]) {
                                        lis = lis + '<li>' + response.responseJSON[key][i] + '</li>';
                                    }
                                }
                            }
                            $clone.find('span').html('<ul>' + lis + '</ul>');
                        }
                        else {
                            $clone.find('span').text(response.responseJSON);
                        }

                        $('.alerts').append($clone);
                        $clone.removeClass('hidden');
                    }
                });
            },
            controleComissaoFiltrar: function() {
                if(this.intervalo != '')
                    this.controleComissaoURL = APP_URL + '/pos-venda/periodo/' + this.intervalo;
            },
            resumoPagamentosFiltrar: function() {
                if(this.intervaloResumo != '')
                    location.href = APP_URL + '/pos-venda/resumo-pagamentos/' + this.intervaloResumo;
            }
        }
    });
</script>
@endpush
