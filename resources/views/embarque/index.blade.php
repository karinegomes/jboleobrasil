@extends('layouts.app')

@section('entity-label', 'Embarques')
@section('entity-url', 'embarques')
@section('action-label', 'Listar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Listar</strong> Embarques</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-8">
                            <button @click="resumo" class="btn btn-default" :disabled="!selected">
                                <i class="fa fa-search mr-5"></i> Visualizar resumo
                            </button>
                            <button @click="adicionar" class="btn btn-default" :disabled="!selected">
                                <span class="fa fa-plus"></span> Adicionar embarque
                            </button>
                            <a href="#search-panel" data-toggle="collapse" class="btn btn-default">
                                <span class="fa fa-file-pdf-o"></span> Imprimir relatório
                            </a>
                            {{--<button @click="copy" class="btn btn-default" :disabled="">
                                <span class="fa fa-file-pdf-o"></span> Imprimir relatório
                            </button>--}}
                        </div>
                        <div class="col-sm-4">
                            <form id="search">
                                <input name="query" v-model="searchQuery" class="input-sm form-control" placeholder="Procurar Contrato...">
                            </form>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 20px">
                        <div class="col-sm-12">
                            <div id="search-panel" class="panel panel-collapse collapse" aria-expanded="true">
                                <div class="panel-body">
                                    <form class="form" method="get" action="{{ url('embarques/relatorio') }}" target="_blank">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="contrato">Contrato</label>
                                                <select name="contrato" id="contrato" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    @foreach($orders as $contrato)
                                                        <option value="{{ $contrato->id }}">{{ $contrato->reference_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="vendedor">Vendedor</label>
                                                <select name="vendedor" id="vendedor" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    @foreach($clientes as $cliente)
                                                        <option value="{{ $cliente->id }}">{{ $cliente->nome_fantasia }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="comprador">Comprador</label>
                                                <select name="comprador" id="comprador" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    @foreach($clientes as $cliente)
                                                        <option value="{{ $cliente->id }}">{{ $cliente->nome_fantasia }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="produto">Produto</label>
                                                <select name="produto" id="produto" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    @foreach($produtos as $produto)
                                                        <option value="{{ $produto->id }}">{{ $produto->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="todos">Todos</option>
                                                    @foreach($status as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-default">Imprimir</button>
                                    </form>
                                </div>
                            </div>
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
@push('scripts')
<script type="text/javascript">
    new Vue({
        el: '#grid',
        data: {
            selected: null,
            searchQuery: '',
            gridData: {!! $orders !!},
            gridColumns: [
                { key: 'reference_code', label: 'Número'},
                { key: entry => {
                    const date = entry.sell_date;

                    if(date){
                        return (new Date(date)).toLocaleDateString();
                    } else {
                        return null;
                    }
                }, label: 'Data'},
                { key: entry => entry.seller.nome_fantasia, label: 'Vendedor'},
                { key: entry => entry.client.nome_fantasia, label: 'Comprador'},
                { key: entry => entry.item.product_name, label: 'Produto'},
                { key: entry => entry.item.amount, label: 'Quantidade'},
                { key: entry => `R$ ${entry.item.price}`, label: 'Valor'},
                { key: entry => {
                    return entry.status[0].toUpperCase() + entry.status.slice(1)
                }, label: 'Status'}
            ]
        },
        methods: {
            resumo: function() {
                location.href = '{{ url('contrato') }}' + '/' + this.selected.id + '/resumo'
            },
            adicionar: function() {
                if(this.selected.status == 'cancelado') {
                    alert('Não é possível adicionar embarque em um pedido cancelado.');
                }
                else {
                    location.href = '{{ url('contrato') }}' + '/' + this.selected.id + '/embarque/adicionar';
                }
            }
        }
    });
</script>
@endpush