@extends('layouts.app')

@section('entity-label', 'Embarques')
@section('entity-url', 'embarques')
@section('action-label', 'Visualizar resumo')

@section('content')
    <div class="alert alert-lightred hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span></span>
    </div>

    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Resumo</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->

                <div class="tile-body form-horizontal">
                    <table>
                        <tbody>
                            <tr>
                                <th>Contrato</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->reference_code }}" readonly></td>
                                <th>Quantidade</th>
                                <td><input type="text" class="form-control" value="{{ number_format($contrato->item->amount, 0, ',', '.') }}" readonly></td>
                                <th>Prazo de entrega</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->detail->type == 'entrega' ? $contrato->detail->description : '' }}" readonly></td>
                            </tr>
                            <tr>
                                <th>Vendedor</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->seller->name }}" readonly></td>
                                <th>Valor unitário</th>
                                <td><input type="text" class="form-control" value="R$ {{ number_format($contrato->item->price, 2, ',', '.') }}" readonly></td>
                                <th>Quantidade de embarques</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->quantidadeEmbarques() }}" readonly></td>
                            </tr>
                            <tr>
                                <th>Comprador</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->client->name }}" readonly></td>
                                <th>Comissão vendedor</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->comissaoVendedor() ? $contrato->comissaoVendedor()->valor_formatado : '' }}" readonly></td>
                                <th>Prazo de pagamento</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->paymethods->last()->days }} dias" readonly></td>
                            </tr>
                            <tr>
                                <th>Produto</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->item->product->name }}" readonly></td>
                                <th>Comissão comprador</th>
                                <td><input type="text" class="form-control" value="{{ $contrato->comissaoComprador() ? $contrato->comissaoComprador()->valor_formatado : '' }}" readonly></td>
                                <th>Status</th>
                                <td><input type="text" class="form-control" value="{{ ucfirst($contrato->status) }}" readonly></td>
                            </tr>
                            <tr>
                                <th>Valor do contrato</th>
                                <td><input type="text" class="form-control" value="R$ {{ number_format($contrato->getValorContrato(), 2, ',', '.') }}" readonly></td>
                                <th>Valor total de comissão</th>
                                <td><input type="text" class="form-control" value="R$ {{ number_format($contrato->valorTotalComissao(), 2, ',', '.') }}" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="tile" id="grid">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Lançamentos</strong> de Embarque</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-10">
                            <button type="button" @click="adicionar" class="btn btn-default btn-sm" :disabled="">
                            <span class="fa fa-plus"></span> Adicionar
                            </button>
                            <button type="button" @click="show" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-search"></span> Visualizar
                            </button>
                            <button type="button" @click="edit" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-pencil"></span> Editar
                            </button>
                            <button type="button" @click="remove" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-trash"></span> Apagar
                            </button>
                        </div>
                        <div class="col-sm-10">

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
            </section>
        </div>
        <!-- /col -->
    </div>
@endsection
@push('components')
@include('components.grid')
@endpush
@push('scripts')
<script type="text/javascript">
    new Vue({
        el: '#grid',
        data: {
            selected: null,
            showModal: false,
            searchQuery: '',
            gridData: JSON.parse('{!! $contrato->embarques !!}'),
            gridColumns: [
                { key: 'entrega', label: 'Entrega' },
                { key: 'nota_fiscal', label: 'Nota Fiscal' },
                { key: entry => {
                    return Number(entry.quantidade).toLocaleString();
                }, label: 'Quantidade' },
                { key: entry => {
                    if(entry.data_embarque != null) {
                        const date = entry.data_embarque + ' 00:00:00';

                        return (new Date(date)).toLocaleDateString();
                    }

                    return null;
                }, label: 'Data Embarque' },
                { key: entry => {
                    return Number(entry.saldo.toFixed(1)).toLocaleString();
                }, label: 'Saldo' },
                { key: 'observacao', label: 'Observação' },
                { key: entry => {
                    if(entry.data_pagamento != null) {
                        const date = entry.data_pagamento + ' 00:00:00';

                        return (new Date(date)).toLocaleDateString();
                    }

                    return null;
                }, label: 'Data Pagto. Mercadoria' },
                { key: 'comissao_vendedor_formatado', label: 'Comissão Vendedor' },
                { key: 'comissao_comprador_formatado', label: 'Comissão Comprador' }
            ]
        },
        methods: {
            adicionar: function() {
                let status = '{{ $contrato->status }}';

                if(status == 'cancelado') {
                    alert('Não é possível adicionar embarque em um pedido cancelado.');
                }
                else {
                    location.href = '{{ url('contrato/' . $contrato->id . '/embarque/adicionar') }}';
                }
            },
            show: function() {
                location.href = '{{ url('embarque') }}' + '/' + this.selected.id;
            },
            edit: function() {
                location.href = '{{ url('embarque') }}' + '/' + this.selected.id + '/editar';
            },
            remove: function(){
                let result = confirm("Deseja realmente apagar esse registro?");

                if(result){
                    $.ajax({
                        url: `{{ url('/embarques') }}/${this.selected.id}`,
                        data: { _token: '{{ csrf_token() }}' },
                        type: 'DELETE',
                        success: function(result) {
                            location.reload();
                        },
                        error: function(response) {
                            $('.alert-lightred span').html(response.responseJSON);
                            $('.alert-lightred').removeClass('hidden');
                        }
                    });
                }
            }
        }
    });
</script>
@endpush
