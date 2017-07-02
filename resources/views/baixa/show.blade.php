@extends('layouts.app')

@section('entity-label', 'Pós-Venda')
@section('entity-url', 'pos-venda')
@section('action-label', 'Visualizar Baixa')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile" id="grid">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Visualizar</strong> Baixa</h1>
                </div>
                <!-- /tile header -->
                <div class="tile-body">
                    <table>
                        <tbody>
                        <tr>
                            <th>Nota Fiscal</th>
                            <td><input type="text" class="form-control" value="{{ $baixa->embarque->nota_fiscal }}" readonly></td>
                            <th>Empresa</th>
                            <td><input type="text" class="form-control" value="{{ $baixa->empresa->nome_fantasia }}" readonly></td>
                            <th>Data do pagamento</th>
                            <td><input type="text" class="form-control" value="{{ $baixa->data_pagamento->format('d/m/Y') }}" readonly></td>
                        </tr>
                        <tr>
                            <th>Valor em cobrança</th>
                            <td><input type="text" class="form-control" value="R$ {{ number_format($baixa->embarque->getValorCobranca(), 2, ',', '.') }}" readonly></td>
                            <th>Valor pago</th>
                            <td><input type="text" class="form-control" value="R$ {{ number_format($baixa->valor, 2, ',', '.') }}" readonly></td>
                            <th>Observação</th>
                            <td><input type="text" class="form-control" value="{{ $baixa->observacao }}" readonly></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection

@include('baixa.includes.push')

@push('styles')
<style>
    table {
        width: 100%;
    }

    table th {
        padding: 0.5em 1.3em;
    }
</style>
@endpush