@extends('layouts.app')

@section('entity-label', 'Ordens de Frete')
@section('entity-url', 'ordens-frete')
@section('action-label', 'Visualizar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Ordem de Frete</h1>
                    <ul class="controls">
                        <li>
                            <a role="button" tabindex="0" href="{{ route('ordens-frete.edit', $ordemFrete) }}">
                                <span class="fa fa-pencil mr-5"></span>Editar
                            </a>
                        </li>
                        <li>
                            <a role="button" tabindex="0" href="#" class="finalizar-btn">
                                Finalizar
                            </a>
                        </li>
                    </ul>

                    <form method="POST"
                          action="{{ route('ordens-frete.finalizar', $ordemFrete) }}"
                          class="finalizar-form">
                        {{ csrf_field() }}
                    </form>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body form-horizontal">
                    <div>
                        @include('ordens_frete.includes.dados')
                    </div>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
    </div>
@endsection

@push('styles')
    <style>
        table th {
            text-align: right;
        }
    </style>
@endpush

@push('components')
    @include('components.grid')
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.finalizar-btn').on('click', function (e) {
                e.preventDefault();

                $('.finalizar-form').submit();
            });
        });
    </script>
@endpush