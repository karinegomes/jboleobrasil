@extends('layouts.app')

@section('entity-label', 'Pós Venda')
@section('entity-url', 'order')
@section('action-label', 'Listar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Gerar</strong> Comissão</h1>
        <ul class="controls">
          <li>
            <a role="button" tabindex="0" href="{{ url('/finance/'.$filter_id) }}">
              <span class="fa fa-file-text mr-5"></span> Gerar Comissão
            </a>
          </li>
        </ul>
      </div>
      <!-- /tile header -->
      <div class="tile-widget">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a href="#search-panel" data-toggle="collapse"><span class="fa fa-filter"></span> Filtrar</a>
            </h4>
          </div>
          <div id="search-panel" class="panel-collapse collapse">
            <div class="panel-body">
              <form class="form">
                <div class="row">
                  <div class="form-group col-md-4">
                    <label>Status</label>
                    <select name="search[status]" class="form-control">
                      <option value="">Todos</option>
                      <option value="1">Em Aberto</option>
                      <option value="2">Pago</option>
                      <option value="3">Cancelado</option>
                      <option value="4">Finalizado</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label>Cliente</label>
                    <input name="search[client_id]" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Contrato</label>
                    <input name="search[reference_code]" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Data</label>
                    <div class="input-group">
                      <span class="input-group-addon">de</span>
                      <input name="search[min_date]" type="date" class="form-control">
                      <span class="input-group-addon">até</span>
                      <input name="search[max_date]" type="date" class="form-control">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-default">Buscar</button>
              </form>
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
      { key: entry => (new Date(entry.sell_date)).toLocaleDateString(), label: 'Data'},
      { key: entry => entry.seller.name, label: 'Vendedor'},
      { key: entry => entry.client.name, label: 'Comprador'},
      { key: entry => !entry.deleted_at ? 'Ativo' : 'Invalidado', label: 'Status'}
    ]
  }
});
</script>
@endpush
