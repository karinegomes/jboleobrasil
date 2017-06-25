@extends('layouts.app')

@section('entity-label', 'Produto')
@section('entity-url', 'product')
@section('action-label', 'Editar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Alterar</strong> Produto</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal" role="form" method="post"
                          action="{{ url('/product/'.$product->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="codigo" class="col-sm-2 control-label">Código</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="codigo" name="product[codigo]"
                                       value="{{ old('product.codigo', $product->codigo) }}">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nome</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="product[name]"
                                       value="{{ old('product.name', $product->name) }}">
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Descrição</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="product[description]"
                                       value="{{ old('product.description', $product->description) }}">
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Fornecedor</label>

                            <div class="col-sm-10">
                                <select tabindex="3" name="product[supplier_id]" class="chosen-select" id="company">
                                    <option value="" {{ old('product.supplier_id') == '' ? 'selected' : '' }}>
                                        Selecionar
                                    </option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $company->id == old('product.supplier_id', $product->supplier_id) ? ' selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">Categoria</label>

                            <div class="col-sm-10">
                                <select id="category" name="product[category_id]" class="chosen-select">
                                    <option value="" {{ old('product.supplier_id') == '' ? 'selected' : '' }}>
                                        Selecionar
                                    </option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"{{ $category->id == old('product.category_id', $product->category_id) ? ' selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group" id="specs">
                            <label class="col-sm-2 control-label">Especificações</label>

                            <div class="col-sm-10">
                                <div class="row mb-10" v-for="spec in specs">
                                    <input type="hidden" name="specs[@{{$index}}][id]" :value="spec.id">

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="specs[@{{$index}}][name]"
                                               placeholder="Nome" :value="spec.name">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="specs[@{{$index}}][value]"
                                               placeholder="Valor" :value="spec.value">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-danger" @click="removeSpec($index)">
                                        <span class="fa fa-times"></span>
                                        Remover
                                        </button>
                                    </div>
                                </div>
                                <hr class="line-dashed line-full"/>
                                <button type="button" class="btn btn-default" @click="addSpec">
                                <span class="fa fa-plus"></span> Adicionar Especificação
                                </button>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="reset" class="btn btn-lightred">Limpar</button>
                                <button type="submit" class="btn btn-default">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('js/chosen/chosen.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
<script type="text/javascript">
    new Vue({
        el: '#specs',
        data: {
            specs: {!! old('specs') ? collect(old('specs')) : $specs !!}

        },
        methods: {
            addSpec: function () {
                this.specs.push({name: '', value: ''});
            },
            removeSpec: function (id) {
                this.specs.splice(id, 1);
            }
        }
    })
</script>
@endpush
