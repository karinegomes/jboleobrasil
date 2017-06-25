@extends('layouts.app')

@section('entity-label', 'Detalhes')
@section('entity-url', 'finance')
@section('action-label', 'Adicionar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Adicionar</strong> Detalhes</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal" role="form" method="post" action="{{ url('/item/'.$order->item->id) }}">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $order->name) }}">
            </div>
            <label for="position" class="col-sm-1 control-label">Cargo</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $order->position) }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $order->email) }}">
            </div>
            <label for="company" class="col-sm-1 control-label">Empresa</label>
            <div class="col-sm-5">
              <input type="hidden" name="company_id" value="{{ isset($order->company) ? $order->company->id : '' }}">
              <p class="form-control-static">{{ isset($order->company) ? $order->company->name : '' }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">DDD</label>
            <div class="col-sm-1">
              <input class="form-control" name="ddd" placeholder="DDD" value="{{ old('ddd', $order->ddd) }}">
            </div>
            <label for="company" class="col-sm-1 control-label">Telefone</label>
            <div class="col-sm-2">
              <input class="form-control" name="number" placeholder="Telefone" value="{{ old('number', $order->number) }}">
            </div>
            <label for="company" class="col-sm-1 control-label">Ramal</label>
            <div class="col-sm-2">
              <input class="form-control" name="extension" placeholder="Ramal" value="{{ old('extension', $order->extension) }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">DDD</label>
            <div class="col-sm-1">
              <input class="form-control" name="mobile_ddd" placeholder="DDD" value="{{ old('mobile_ddd', $order->mobile_ddd) }}">
            </div>
            <label for="company" class="col-sm-1 control-label">Celular</label>
            <div class="col-sm-2">
              <input class="form-control" name="mobile_number" placeholder="Celular" value="{{ old('mobile_number', $order->mobile_number) }}">
            </div>
            <label for="company" class="col-sm-1 control-label">Operadora</label>
            <div class="col-sm-2">
              <select class="form-control" name="carrier_id">
                  @if(isset($carriers))
                @foreach($carriers as $carrier)
                <option value="{{ $carrier->id }}"{{ $carrier->id == old('carrier_id', $order->carrier_id) ? ' selected' : '' }}>
                  {{ $carrier->name }}
                </option>
                @endforeach
                      @endif
              </select>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Detalhes Principal</label>
            <div class="col-sm-1">
              <label>
                <input type="checkbox" name="main" value="1"{{ old('main', $order->main) == 1 ? ' checked' : '' }}>
              </label>
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
@endpush
