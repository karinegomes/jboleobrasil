@extends('layouts.app')

@section('entity-label', 'Cliente')
@section('entity-url', 'company')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Cliente</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ url('/company/'.$company->id.'/edit') }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body form-horizontal">
                    @include('include.dados_cliente')
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="tile" id="grid">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Documentos</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-10">
                            <button type="button" @click="read" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-search"></span> Visualizar
                            </button>
                            <button type="button" @click="remove" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-trash"></span> Apagar
                            </button>
                        </div>
                        <div class="col-sm-10">
                            <form class="form-inline"
                                  action="{{ route('companies.documents.store', $company) }}"
                                  method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{--<input type="hidden" name="company_id" value="{{ $company->id }}">--}}

                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Arquivo</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Tipo de Documento</label>
                                    <select class="form-control" name="doctype_id">
                                        @foreach($doctypes as $doctype)
                                            <option value="{{ $doctype->id }}">{{ $doctype->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">Adicionar</button>
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
            </section>
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
            gridData: {!! $company->documents !!},
            gridColumns: [
                { key: 'name', label: 'Nome' },
                { key: (entry) => entry.doctype.name, label: 'Tipo de Documento' },
    { key: (entry) => (new Date(entry.created_at)).toLocaleDateString(), label: 'Inserido em' }
    ]
    },
    methods: {
        read: function(){
            window.open(`{{ url('/document') }}/${this.selected.id}`, '_blank');
        },
        remove: function(){
            let result = confirm("Deseja realmente apagar esse registro?");

            if(result){
                $.ajax({
                    url: `{{ url('/document') }}/${this.selected.id}`,
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
