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
        <h1 class="custom-font"><strong>Copiar</strong> Contato</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal" role="form" method="post" action="{{ url('/order') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="col-sm-2 control-label">Código</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" value="{{ $reference_code }}" disabled="disabled">
            </div>
            <label class="col-sm-2 control-label">Referência</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="order[reference_order]" value="{{ $order->reference_code }}" readonly="readonly">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Data do Contrato</label>
            <div class="col-sm-10">
              <div class='input-group date' id='sell_date'>
                <input type="text" class="form-control" id="date" name="order[sell_date]" value="{{ $order->sell_date->format('d/m/Y') }}">
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
                @foreach($companies as $company)
                <option value="{{ $company->id }}"{{ ($order->seller_id === $company->id) ? ' selected':'' }}>
                  {{ $company->name }}
                </option>
                @endforeach
              </select>
            </div>
            <label for="company" class="col-sm-2 control-label">Comprador</label>
            <div class="col-sm-4">
              <select name="order[client_id]" class="chosen-select">
                @foreach($companies as $company)
                <option value="{{ $company->id }}"{{ ($order->client_id === $company->id) ? ' selected':'' }}>
                  {{ $company->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group" id="product_calc">
            <label for="company" class="col-sm-2 mb-5 control-label">Produto</label>
            <div class="col-sm-4 mb-5">
              <select class="form-control" name="item[product_id]" v-model="selected" style="min-width: 250px">
                <option v-for="p in products" value="@{{p.id}}">
                  @{{ p.name }}
                </option>
              </select>
            </div>
            <label for="expiry" class="col-sm-2 mb-5 control-label">Data de Vencimento</label>
            <div class="col-sm-4 mb-5">
              <div class='input-group date' id='expiry'>
                <input type="text" class="form-control" id="date" name="item[expiry]" value="{{ $order->item->expiry->format('d/m/Y') }}">
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
            </div>
            <label for="amount" class="col-sm-2 control-label">Medida</label>
            <div class="col-sm-2">
              <select name="item[measure_id]" class="form-control">
                @foreach($measures as $measure)
                <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                @endforeach
              </select>
            </div>
            <label for="amount" class="col-sm-1 control-label">Quantidade</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="item[amount]" v-model="amount">
            </div>
            <label for="amount" class="col-sm-1 control-label">Preço</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="item[price]" v-model="price">
            </div>
            <span v-show="!!amount && !!price">
              <label for="amount" class="col-sm-1 control-label">Total</label>
              <div class="col-sm-1">
                <p class="form-control-static">
                  R$ @{{ amount * price }}
                </p>
              </div>
            </span>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="package" class="col-sm-2 control-label">Embalagem</label>
            <div class="col-sm-10">
              <select name="item[package_id]" class="form-control">
                @foreach($packages as $package)
                <option value="{{ $package->id }}"{{ ($order->item->package_id === $package->id) ? ' selected':'' }}>
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
              <select name="freight[transporter_id]" class="chosen-select" id="transp">
                @foreach($companies as $company)
                <option value="{{ $company->id }}"{{ ($order->freight->transporter_id === $company->id) ? ' selected':'' }}>
                  {{ $company->name }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="incoterm" class="col-sm-2 control-label">Modalidade</label>
            <div class="col-sm-3">
              <select name="freight[incoterm_id]" class="chosen-select" id="incoterm">
                @foreach($incoterms as $incoterm)
                <option value="{{ $incoterm->id }}"{{ ($order->freight->incoterm_id === $incoterm->id) ? ' selected':'' }}>
                  {{ $incoterm->abbreviation }}
                </option>
                @endforeach
              </select>
            </div>
            <label for="incoterm" class="col-sm-2 control-label">Endereço de Entrega</label>
            <div class="col-sm-5">
              <input type="text" name="freight[address]" class="form-control" value="{{$order->freight->address}}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="det" class="col-sm-2 control-label">Detalhes</label>
            <div class="col-sm-3">
              <select name="detail[type]" class="form-control mb-5" id="det">
                @foreach($detail_types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-7">
              <input class="form-control" name="detail[description]" value="{{ $order->detail->description }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group" id="comissao">
            <label for="com" class="col-sm-2 control-label">Comissão</label>
            <div class="col-sm-3">
              <select name="order[commission_unit]" class="form-control" v-model="type" @change="setType">
                <option value="porcentagem">Porcentagem</option>
                <option value="fixo">Valor Fixo</option>
              </select>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon" v-show="type === 'fixo'">R$</span>
                <input class="form-control" name="order[commission_value]" placeholder="Valor" value="{{$order->commission_value}}">
                <span class="input-group-addon" v-show="type === 'porcentagem'">%</span>
              </div>
            </div>
            <div class="col-sm-4">
              <select name="order[commission_type]" class="form-control">
                <option value="vendedor"{{ ($order->commission_type === 'vendedor') ? ' selected':'' }}>
                  Comissão por Conta do Vendedor
                </option>
                <option value="comprador"{{ ($order->commission_type === 'comprador') ? ' selected':'' }}>
                  Comissão por Conta do Comprador
                </option>
								<option value="ambos"{{ ($order->commission_type === 'ambos') ? ' selected':'' }}>
									Comissão por Conta do Vendedor e Comprador
								</option>
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>

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
              <textarea id="obs" rows="8" class="form-control" name="order[observation]">{{$order->observation}}</textarea>
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
    amount: {{ $order->item->amount }},
    price: {{ $order->item->price }}
  }
});

new Vue({
  el: '#comissao',
  data: {
    type: '{{ $order->commission_unit }}'
  }
});

$(document).ready(function() {
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
