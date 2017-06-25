@extends('layouts.app')

@section('entity-label', 'Contato')
@section('entity-url', 'client')
@section('action-label', 'Listar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Listar</strong> Contatos</h1>
        <ul class="controls">
          <li>
            <a role="button" tabindex="0" href="{{ url('/client/create') }}">
              <span class="fa fa-plus mr-5"></span> Adicionar
            </a>
          </li>
        </ul>
      </div>
      <!-- /tile header -->
      <div class="tile-widget">
        <div class="row">
          <div class="col-sm-8">
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
      <div class="tile-footer dvd dvd-top">
        <a href="{{ url('/client') }}" class="btn btn-default">Todos</a>
        @foreach($groups as $group)
        <a href="{{ url('/client?group='.$group->id) }}" class="btn btn-default">{{ $group->name }}</a>
        @endforeach
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
    gridData: {!! $clients !!},
    gridColumns: [
      { key: 'company_name', label: 'Empresa'},
      { key: 'name', label: 'Nome'},
      { key: 'state_name', label: 'Cidade'},
      { key: 'last_note', label: 'Última Anotação'},
      { key: 'main_phone', label: 'Telefone Principal'},
      { key: 'email', label: 'E-mail'}
    ]
  },
  methods: {
    read: function(){
      location.href = `{{ url('/client') }}/${this.selected.id}`;
    },
    edit: function(){
      location.href = `{{ url('/client') }}/${this.selected.id}/edit`;
    },
    remove: function(){
      let result = confirm("Deseja realmente apagar esse registro?");

      if(result){
        $.ajax({
          url: `{{ url('/client') }}/${this.selected.id}`,
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
