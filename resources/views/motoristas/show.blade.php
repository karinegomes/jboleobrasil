@extends('layouts.app')

@section('entity-label', 'Motoristas')
@section('entity-url', 'motoristas')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Motorista</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ route('motoristas.edit', $motorista) }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body form-horizontal">
                    @include('motoristas.includes.dados_motorista')
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>

    @include('motoristas.includes.visualizar_documentos')
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
                gridData: {!! $motorista->documents !!},
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