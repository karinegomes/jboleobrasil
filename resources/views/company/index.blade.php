@extends('layouts.app')

@section('entity-label', 'Cliente')
@section('entity-url', 'company')
@section('action-label', 'Listar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Listar</strong> Clientes</h1>
        {{--<ul class="controls">
          <li>
            <a role="button" tabindex="0" href="{{ url('/company/create') }}">
              <i class="fa fa-plus mr-5"></i> Adicionar
            </a>
          </li>
        </ul>--}}
      </div>
      <!-- /tile header -->
      <div class="tile-widget">
        <div class="row">
          <div class="col-sm-8">
            <button @click="add" class="btn btn-default" :disabled="">
            <i class="fa fa-plus mr-5"></i> Adicionar
            </button>
            <button @click="read" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-search"></span> Visualizar
            </button>
            <button @click="edit" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-pencil"></span> Editar
            </button>
            <button @click="remove" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-times"></span> Apagar
            </button>
          </div>
          <div class="col-sm-4">
            <form id="search">
              <input name="query" v-model="searchQuery" class="input-sm form-control" placeholder="Procurar Contrato...">
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
    searchQuery: '',
    gridData: {!! $companies !!},
    gridColumns: [
      { key: 'codigo', label: 'Código' },
      { key: 'nome_fantasia', label: 'Empresa'},
      { key: 'group_name', label: 'Tipo'},
      { key: 'state_name', label: 'Cidade'},
      { key: 'registry', label: 'CNPJ'}
    ]
  },
  methods: {
    add: function() {
      location.href = '{{ url('company/create') }}'
    },
    read: function(){
      location.href = `{{ url('/company') }}/${this.selected.id}`;
    },
    edit: function(){
      location.href = `{{ url('/company') }}/${this.selected.id}/edit`;
    },
    remove: function(){
      let result = confirm("Deseja realmente apagar esse registro?");

      if(result){
        $.ajax({
          url: `{{ url('/company') }}/${this.selected.id}`,
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
