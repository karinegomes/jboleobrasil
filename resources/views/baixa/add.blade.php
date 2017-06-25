@extends('layouts.app')

@section('entity-label', 'Pós-Venda')
@section('entity-url', 'pos-venda')
@section('action-label', 'Baixa')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Baixa</strong></h1>
                </div>
                <!-- /tile header -->
                <div class="tile-body">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <form class="form-horizontal" role="form" method="post" action="">
                                @include('baixa.includes.form', ['edit' => false])
                            </form>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection

@include('baixa.includes.push')