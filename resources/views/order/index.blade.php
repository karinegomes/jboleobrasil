@extends('layouts.app')

@section('entity-label', 'Contrato')
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
        <h1 class="custom-font"><strong>Listar</strong> Contratos</h1>
      </div>
      <!-- /tile header -->
      <div class="tile-widget">
        <div class="row">
          <div class="col-sm-8">
            <button @click="add" class="btn btn-default" :disabled="">
              <i class="fa fa-plus mr-5"></i> Adicionar
            </button>
            <button @click="copy" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-files-o"></span> Copiar
            </button>
            <button @click="cancel" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-times"></span> Cancelar pedido
            </button>
            <button @click="read_vendedor" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-file-pdf-o"></span> Gerar Contrato - Vendedor
            </button>
            <button @click="read_comprador" class="btn btn-default" :disabled="!selected">
              <span class="fa fa-file-pdf-o"></span> Gerar Contrato - Comprador
            </button>
            <button @click="edit" class="btn btn-default" :disabled="!selected || selected.deleted_at">
            <span class="fa fa-pencil"></span> Editar
            </button>
            <button @click="delete" class="btn btn-default" :disabled="!selected || selected.deleted_at">
            <span class="fa fa-trash"></span> Apagar
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
    gridData: {!! $orders !!},
    gridColumns: [
      { key: 'reference_code', label: 'Número'},
      { key: entry => {
        const date = entry.sell_date;

        if(date){
          return (new Date(date)).toLocaleDateString();
        } else {
          return null;
        }
      }, label: 'Data'},
      { key: entry => entry.seller.name, label: 'Vendedor'},
      { key: entry => entry.client.name, label: 'Comprador'},
      { key: entry => entry.item.product_name, label: 'Produto'},
      { key: entry => entry.item.amount, label: 'Quantidade'},
      { key: entry => `R$ ${entry.item.price}`, label: 'Valor'},
      { key: entry => {
          return entry.status[0].toUpperCase() + entry.status.slice(1)
      }, label: 'Status'}
    ]
  },
  methods: {
    add: function() {
      location.href = '{{ url('order/create') }}'
    },
    read_vendedor: function(){
      console.log(this.selected);
      const reference = this.selected.reference_code.replace('/', '-');
      window.open(`{{ url('/order') }}/vendedor/${reference}`, '_blank');
    },
    read_comprador: function(){
      const reference = this.selected.reference_code.replace('/', '-');
      window.open(`{{ url('/order') }}/comprador/${reference}`, '_blank');
    },
    edit: function(){
      location.href = `{{ url('/order') }}/${this.selected.id}/edit`;
    },
    copy: function(){
      location.href = `{{ url('/order/create') }}?reference_order=${this.selected.id}`;
    },
    delete: function(){
      let result = confirm("Deseja realmente apagar esse contrato?");

      if(result){
        $.ajax({
          url: `{{ url('/order') }}/${this.selected.id}`,
          data: { _token: '{{ csrf_token() }}' },
          type: 'DELETE',
          success: function(result) {
            location.reload();
          }
        });
      }
    },
    cancel: function() {
        let result = confirm("Deseja realmente cancelar esse pedido?");
        let $this = this;

        $('.alert').remove();

        if(result){
            $.ajax({
                url: `{{ url('contrato') }}/${this.selected.id}/cancelar`,
                data: { _token: '{{ csrf_token() }}' },
                type: 'POST',
                success: function(result) {
                    $('.pageheader').after('<div class="alert alert-success">\
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                                              ' + result + '\
                                            </div>');

                    $this.selected.status = 'Cancelado';
                },
                error: function(response) {
                    console.log(response.responseJSON);

                    $('.pageheader').after('<div class="alert alert-danger">\
                                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                                              ' + response.responseJSON + '\
                                            </div>');
                }
            });
        }
    }
  }
});
</script>
@endpush
