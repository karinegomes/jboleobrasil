@extends('layouts.app')

@section('entity-label', 'Usuário')
@section('entity-url', 'user')
@section('action-label', 'Listar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile" id="grid">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Listar</strong> Usuários</h1>
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
    gridData: {!! $users !!},
    gridColumns: [
      { key: 'name', label: 'Nome'},
      { key: 'email', label: 'Email'},
      { key: entry => `(${entry.phone_ddd}) ${entry.phone}`, label: 'Telefone'},
      { key: entry => `(${entry.mobile_ddd}) ${entry.mobile_phone}`, label: 'Celular'},
      { key: 'skype', label: 'Skype'}
    ]
  },
  methods: {
    add: function() {
      location.href = '{{ url('user/create') }}'
    },
    read: function(){
      location.href = `{{ url('/user') }}/${this.selected.id}`;
    }
  }
});
</script>
@endpush
