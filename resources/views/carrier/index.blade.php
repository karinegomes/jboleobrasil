@extends('layouts.app')

@section('entity-label', 'Operadora')
@section('entity-url', 'carrier')
@section('action-label', 'Listar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Listar</strong> Operadoras</h1>
      </div>
      <!-- /tile header -->
      <div class="tile-widget">
        <div class="row">
          <div class="col-sm-8">
            <button type="button" @click="remove" class="btn btn-default btn-sm">
              <span class="fa fa-trash"></span> Apagar
            </button>
          </div>
          <div class="col-sm-4">
            <form class="form-inline" method="post" action="{{ url('/carrier') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control input-sm" id="nome" name="name" required>
              </div>
              <button class="btn btn-default btn-sm" type="submit">
                <span class="fa fa-plus"></span> Adicionar
              </button>
            </form>
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
    showModal: false,
    searchQuery: '',
    gridData: {!! $carriers !!},
    gridColumns: [
      { key: 'name', label: 'Nome' }
    ]
  },
  methods: {
    remove: function(){
      let result = confirm("Deseja realmente apagar esse registro?");

      if(result){
        $.ajax({
          url: `{{ url('/carrier') }}/${this.selected.id}`,
          data: { _token: '{{ csrf_token() }}' },
          type: 'DELETE',
          success: function(result) {
            location.reload();
          }
        });
      }
    }
  }
});
</script>
@endpush
