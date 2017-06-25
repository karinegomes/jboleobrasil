@extends('layouts.app')

@section('entity-label', 'Agenda')
@section('entity-url', 'agenda')
@section('action-label', 'Listar')

@section('content')

    @include('include.message')
    @include('include.error')

<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Agenda</strong> de Clientes</h1>
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
          </div>
          <div class="col-sm-4">
            <form id="search">
              <input name="query" v-model="searchQuery" class="input-sm form-control" placeholder="Procurar Contato...">
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
  @include('components.grid-agenda')
@endpush
@push('scripts')
<script type="text/javascript">
const v = new Vue({
  el: '#grid',
  data: {
    selected: null,
    showModal: false,
    searchQuery: '',
    gridData: {!! $clients !!},
    gridColumns: [
        { key: 'last_note', label: 'Última Anotação'},
        { key: 'codigo', label: 'Código' },
        { key: 'nome_fantasia', label: 'Empresa'},
        { key: 'group_name', label: 'Tipo'},
        { key: 'state_name', label: 'Cidade'},
        { key: 'main_phone', label: 'Telefone Principal'},
        { key: 'proximo_compromisso_formatado', label: 'Data do compromisso'}

    ]
  },
  methods: {
    add: function() {
      location.href = '{{ url('client/create') }}'
    },
    read: function(){
      location.href = `{{ url('/agenda') }}/${this.selected.id}`;
    }
  }
});
</script>
@endpush
