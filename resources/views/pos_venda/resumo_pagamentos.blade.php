@extends('layouts.app')

@section('entity-label', 'Pós-Venda')
@section('entity-url', 'pos-venda')
@section('action-label', 'Resumo de pagamentos')

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
                    <h1 class="custom-font">
                        <strong>Resumo</strong> de Pagamentos - <strong>{{ $periodoFormatado }}</strong>
                    </h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="pl-0 pr-0" style="background-color: #acacac; height: 60vh">
                    <grid-resumo-pagamentos
                            :data="gridData"
                            :selected.sync="selected"
                            :columns="gridColumns"
                            :filter-key="searchQuery"
                            :clientes="clientes"
                            :intervalo="intervalo">
                    </grid-resumo-pagamentos>
                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection

@push('components')
@include('pos_venda.includes.grid_resumo_pagamentos')
@endpush

@push('scripts')
<script src="{{ asset('js/moment/moment.min.js') }}"></script>

<script type="text/javascript">
    const v = new Vue({
        el: '#grid',
        data: {
            selected: null,
            searchQuery: '',
            gridData: '',
            gridColumns: [
                { key: entry => {
                    return entry.embarque.nota_fiscal;
                }, label: 'Nota Fiscal' },
                { key: entry => {
                    return entry.embarque.contrato.seller.nome_fantasia;
                }, label: 'Vendedor' },
                { key: entry => {
                    return entry.embarque.contrato.client.nome_fantasia;
                }, label: 'Comprador' },
                { key: entry => {
                    return moment(entry.data_pagamento, 'YYYY-MM-DD').format('DD/MM/YYYY');
                }, label: 'Data do pagamento' },
                { key: entry => {
                    return entry.embarque.contrato.reference_code;
                }, label: 'Contrato' },
                { key: entry => {
                    return entry.embarque.contrato.item.product.name;
                }, label: 'Produto' },
                { key: entry => {
                    return Number(entry.embarque.quantidade).toLocaleString();
                }, label: 'Quantidade' },
                { key: 'porcentagem_comissao', label: '% Comissão' },
                { key: 'valor_formatado', label: 'Valor' }
            ],
            clientes: {!! $clientes !!},
            intervalo: '{!! $intervalo !!}'
        }
    });
</script>
@endpush