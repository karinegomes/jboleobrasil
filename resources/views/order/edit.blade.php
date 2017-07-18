@extends('layouts.app')

@section('entity-label', 'Contrato')
@section('entity-url', 'order')
@section('action-label', 'Editar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Editar</strong> Contrato</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal" role="form" method="post" action="{{ url('/order/'.$order->id) }}">
					<input type="hidden" name="_method" value="PUT">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="col-sm-2 control-label">Código</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" value="{{ $order->reference_code }}" name="order[reference_code]">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Data do Contrato</label>
            <div class="col-sm-10">
              <div class='input-group date' id='sell_date'>
                <input type="text" class="form-control" id="date" name="order[sell_date]"
                  value="{{ old('order.sell_date', $order->sell_date->format('d/m/Y')) }}">
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Vendedor</label>
            <div class="col-sm-4">
              <select name="order[seller_id]" class="chosen-select">
                <option value="" {{ old('order.seller_id') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ (old('order.seller_id', $order->seller_id) == $company->id) ? ' selected':'' }}>
                  {{ $company->name }}
                </option>
                @endforeach
              </select>
            </div>
            <label for="company" class="col-sm-2 control-label">Comprador</label>
            <div class="col-sm-4">
              <select name="order[client_id]" class="chosen-select">
                <option value="" {{ old('order.client_id', $order->client_id) == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ (old('order.client_id', $order->client_id) == $company->id) ? ' selected':'' }}>
                  {{ $company->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group" id="product_calc">
            <label for="company" class="col-sm-2 mb-5 control-label">Produto</label>
            <div class="col-sm-10 mb-5">
              <select class="form-control" name="item[product_id]" style="min-width: 250px">
                <option value="" {{ old('item.product_id') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($products as $product)
                  <option value="{{ $product->id }}" {{ old('item.product_id', $order->item->product_id) == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <label for="amount" class="col-sm-2 control-label">Medida</label>
            <div class="col-sm-2">
              <select name="item[measure_id]" class="form-control">
                <option value="" {{ old('item.measure_id') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($measures as $measure)
                  <option value="{{ $measure->id }}"
                    {{ old('item.measure_id', $order->item->measure_id) == $measure->id ? 'selected' : '' }}>
                    {{ $measure->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <label for="amount" class="col-sm-1 control-label">Quantidade</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="item[amount]" id="quantidade"
                value="{{ old('item.amount', intval($order->item->amount)) }}">
            </div>
            <label for="amount" class="col-sm-1 control-label">Preço</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="item[price]" id="preco"
                value="{{ old('item.price', $order->item->price) }}">
            </div>
            <span>
              <label for="amount" class="col-sm-1 control-label">Total</label>
              <div class="col-sm-1">
                <p class="form-control-static">
                  {{--R$ @{{ amount * price }}--}}
                  R$ <span class="total">{{ number_format($order->item->amount * $order->item->price, 2, ',', '.') }}</span>
                </p>
              </div>
            </span>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="package" class="col-sm-2 control-label">Embalagem</label>
            <div class="col-sm-10">
              <select name="item[package_id]" class="form-control">
                <option value="" {{ old('item.package_id') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($packages as $package)
                <option value="{{ $package->id }}" {{ (old('item.package_id', $order->item->package_id) == $package->id) ? ' selected':'' }}>
                  {{ $package->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="transp" class="col-sm-2 control-label">Transportadora</label>
            <div class="col-sm-10">
              <input type="text" name="freight[transportadora]" class="form-control" id="transp"
                value="{{ old('freight.transportadora', $order->freight->transportadora) }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="incoterm" class="col-sm-2 control-label">Modalidade</label>
            <div class="col-sm-3">
              <select name="freight[incoterm_id]" class="chosen-select" id="incoterm">
                <option value="" {{ old('freight.incoterm_id') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($incoterms as $incoterm)
                <option value="{{ $incoterm->id }}"
                  {{ (old('freight.incoterm_id', $order->freight->incoterm_id) == $incoterm->id) ? ' selected':'' }}>
                  {{ $incoterm->abbreviation }}
                </option>
                @endforeach
              </select>
            </div>
            <label for="incoterm" class="col-sm-2 control-label">Endereço de Entrega</label>
            <div class="col-sm-5">
              <input type="text" name="freight[address]" class="form-control"
                value="{{ old('freight.address', $order->freight->address) }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="det" class="col-sm-2 control-label">Detalhes</label>
            <div class="col-sm-3">
              <select name="detail[type]" class="form-control mb-5" id="det">
                <option value="" {{ old('detail.type') == '' ? 'selected' : '' }}>Selecionar</option>
                @foreach($detail_types as $type)
                  <option value="{{ $type->id }}" {{ old('detail.type', $order->detail->type) == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-7">
              <input class="form-control" name="detail[description]"
                value="{{ old('detail.description', $order->detail->description) }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group" id="comissao_vendedor">
            <label for="com" class="col-sm-2 control-label">Comissão Vendedor</label>
            <div class="col-sm-3">
              <select name="comissao[0][unidade]" class="form-control" v-model="type" @change="setType">
              <option value="porcentagem" {{ old('comissao.0.unidade', $order->comissaoVendedor() ? $order->comissaoVendedor()->unidade : '') == 'porcentagem' ? 'selected' : '' }}>
                Porcentagem
              </option>
              <option value="fixo" {{ old('comissao.0.unidade', $order->comissaoVendedor() ? $order->comissaoVendedor()->unidade : '') == 'fixo' ? 'selected' : '' }}>
                Valor Fixo
              </option>
              </select>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon" v-show="type === 'fixo'">R$</span>
                <input class="form-control" name="comissao[0][valor]" placeholder="Valor" value="{{ old('comissao.0.valor', $order->comissaoVendedor() ? $order->comissaoVendedor()->valor : '') }}">
                <span class="input-group-addon" v-show="type === 'porcentagem'">%</span>
              </div>
            </div>
            <input type="hidden" name="comissao[0][tipo]" value="vendedor">
          </div>

          <div class="form-group" id="comissao_comprador">
            <label for="com" class="col-sm-2 control-label">Comissão Comprador</label>
            <div class="col-sm-3">
              <select name="comissao[1][unidade]" class="form-control" v-model="type" @change="setType">
              <option value="porcentagem" {{ old('comissao.1.unidade', $order->comissaoComprador() ? $order->comissaoComprador()->unidade : '') == 'porcentagem' ? 'selected' : '' }}>
                Porcentagem
              </option>
              <option value="fixo" {{ old('comissao.1.unidade', $order->comissaoComprador() ? $order->comissaoComprador()->unidade : '') == 'fixo' ? 'selected' : '' }}>
                Valor Fixo
              </option>
              </select>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon" v-show="type === 'fixo'">R$</span>
                <input class="form-control" name="comissao[1][valor]" placeholder="Valor" value="{{ old('comissao.1.valor', $order->comissaoComprador() ? $order->comissaoComprador()->valor : '') }}">
                <span class="input-group-addon" v-show="type === 'porcentagem'">%</span>
              </div>
            </div>
            <input type="hidden" name="comissao[1][tipo]" value="comprador">
          </div>
          <hr class="line-dashed line-full"/>

          <div class="form-group">
            <label for="forma_pagamento" class="col-sm-2 control-label">Forma de cobrança</label>
            <div class="col-sm-10">
              <input class="form-control" name="order[forma_pagamento]"
                value="{{ old('order.forma_pagamento', $order->forma_pagamento) }}">
            </div>
          </div>

          @foreach($order->paymethods as $key => $paymethod)
            @include('order.includes.condicao_pagamento', [
                'count' => $key,
                'days' => $paymethod->days,
                'name' => $paymethod->name
            ])
          @endforeach

          <div class="form-group">
            <label for="cond" class="col-sm-2 control-label"></label>
            <div class="col-sm-2">
              <button type="button" class="btn btn-default add-condicao-pagamento">
                <span class="fa fa-plus"></span> Adicionar
              </button>
            </div>
          </div>

          <div class="form-group">
            <label for="dados_bancarios" class="col-sm-2 control-label">Dados bancários</label>
            <div class="col-sm-10">
              <input class="form-control" name="order[dados_bancarios]"
                value="{{ old('order.dados_bancarios', $order->dados_bancarios) }}">
            </div>
          </div>

          <hr class="line-dashed line-full"/>

          <div class="form-group" id="taxes">
            <label for="company" class="col-sm-2 control-label">Impostos</label>
            <div class="col-sm-10">
              <div class="row mb-5" v-for="tel in taxes">
                <div class="col-sm-3">
                  <div class="input-group">
                    <input class="form-control" name="taxes[@{{$index}}][value]" placeholder="Valor" :value="tel.value">
                    <span class="input-group-addon">%</span>
                  </div>
                </div>
                <div class="col-sm-2">
                  <select class="form-control" name="taxes[@{{$index}}][type]" :value="tel.type" v-model="tel.type">
                    @foreach($tax_types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-danger" @click="removeTax($index)">
                    <span class="fa fa-times"></span>
                    Remover
                  </button>
                </div>
              </div>
              <hr class="line-dashed line-full" />
              <button type="button" class="btn btn-default" @click="addTax">
                <span class="fa fa-plus"></span>
                Adicionar Imposto
              </button>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="obs" class="col-sm-2 control-label">Observação</label>
            <div class="col-sm-10">
              <textarea id="obs" rows="8" class="form-control" name="order[observation]">{!! old('order.observation', $order->observation) !!}</textarea>
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
<link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mask/jquery.mask.js') }}"></script>
<script type="text/javascript">
$('.date').datetimepicker({
  format: 'DD/MM/YYYY',
  showTodayButton: true
});

new Vue({
  el: '#taxes',
  data: {
    taxes: {!! $taxes !!}
  },
  methods: {
    addTax: function(){
      this.taxes.push({value: '', type: null});
    },
    removeTax: function(id){
      this.taxes.splice(id, 1);
    }
  }
});

new Vue({
  el: '#product_calc',
  data: {
    products: {!! $products !!},
    selected: {{ $order->item->product_id }},
    /*amount: {{ $order->item->amount }},
    price: {{ $order->item->price }}*/
  }
});

new Vue({
  el: '#comissao_vendedor',
  data: {
    type: '{{ old('comissao.0.unidade', $order->comissaoVendedor() ? $order->comissaoVendedor()->unidade : 'porcentagem') }}'
  }
});

new Vue({
    el: '#comissao_comprador',
    data: {
        type: '{{ old('comissao.1.unidade', $order->comissaoComprador() ? $order->comissaoComprador()->unidade : 'porcentagem') }}'
    }
});

$(document).ready(function() {
  //$('#quantidade').mask("#.##0,00", {reverse: true});
  $('#preco').mask("#.##0,00", {reverse: true});

  $('#quantidade, #preco').on('keyup', function() {
    var quantidade = $('#quantidade').val();
    var preco = $('#preco').val();

    if(quantidade != '' && preco != '') {
      //quantidade = quantidade.replace(/\./g, '').replace(',', '.');
      preco = preco.replace(/\./g, '').replace(',', '.');

      var total = quantidade * preco;

      $('.total').text(total.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
    }
  });

    $('.add-condicao-pagamento').on('click', function() {
        var $clone       = $('.condicao-pagamento-wrapper:first').clone();
        var $lastWrapper = $('.condicao-pagamento-wrapper:last');
        var count        = $lastWrapper.data('count');

        $clone.find('label').text('');
        $clone.find('input:first').val('');
        $clone.find('.remover-condicao-pagamento-wrapper').removeClass('hidden');
        $clone.attr('data-count', count + 1);
        $clone.find('.dias-pagamento').attr('name', 'paymethod[' + (count + 1) + '][days]');
        $clone.find('.pagamento-comp').attr('name', 'paymethod[' + (count + 1) + '][name]');
        $lastWrapper.after($clone);
    });

    $(document).on('click', '.remover-condicao-pagamento', function() {
        $(this).parents('.condicao-pagamento-wrapper').remove();
    });
});
</script>
@endpush
