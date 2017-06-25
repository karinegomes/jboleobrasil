@extends('layouts.app')

@section('entity-label', 'Períodos de Cobrança')
@section('entity-url', 'periodo-cobranca')
@section('action-label', 'Listar')

@section('content')
    <div class="alerts"></div>

    {{--<div class="alert alert-success hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span></span>
    </div>--}}

    <div class="alert alert-danger hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span></span>
    </div>

    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Listar</strong> Períodos de Cobrança</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-sm-8">
                            <button @click="remove" class="btn btn-default" :disabled="!selected">
                                <span class="fa fa-times"></span> Apagar
                            </button>
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
<script src="{{ asset('js/moment/moment.min.js') }}"></script>

<script type="text/javascript">
    new Vue({
        el: '#grid',
        data: {
            selected: null,
            searchQuery: '',
            gridData: {!! $periodos !!},
            gridColumns: [
                {key: entry => {
                    return moment(entry.min_date, 'YYYY-MM-DD').format('DD/MM/YYYY');
                }, label: 'Data mínima'},
                {key: entry => {
                    return moment(entry.max_date, 'YYYY-MM-DD').format('DD/MM/YYYY')
                }, label: 'Data máxima'}
            ]
        },
        methods: {
            remove: function () {
                let result = confirm("Deseja realmente apagar esse registro?");

                if (result) {
                    $.ajax({
                        url: `{{ url('periodo-cobranca') }}/${this.selected.id}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        type: 'DELETE',
                        success: function (result) {
                            console.log(result);

                            location.reload();
                        },
                        error: function(response) {
                            console.log(response);

                            var $clone = $('.alert-danger').clone();

                            $clone.find('span').text(response.responseJSON);
                            $('.alerts').append($clone);
                            $clone.removeClass('hidden');
                        }
                    });
                }
            }
        }
    });
</script>
@endpush