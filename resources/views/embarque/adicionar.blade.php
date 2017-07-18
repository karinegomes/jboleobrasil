@extends('layouts.app')

@section('entity-label', 'Embarques')
@section('entity-url', 'embarques')
@section('action-label', 'Adicionar Lançamento de Embarque')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Adicionar</strong> Lançamento de Embarque</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ url('contrato/' . $idContrato . '/embarque') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-5">
                                        <select name="status" class="form-control">
                                            <option value="ativo" selected>Ativo</option>
                                            <option value="liquidado">Liquidado</option>
                                            <option value="encerrado">Encerrado</option>
                                            <option value="cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="entrega" class="col-sm-3 control-label">Entrega</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="entrega" class="form-control" value="{{ $entrega }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nota_fiscal" class="col-sm-3 control-label">Nota Fiscal</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="nota_fiscal" class="form-control" value="{{ old('nota_fiscal') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="quantidade" class="col-sm-3 control-label">Quantidade</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="quantidade" class="form-control" value="{{ old('quantidade') }}" id="quantidade">
                                    </div>

                                    <div class="col-sm-2">
                                        <div style="padding-top: 7px; text-align: right">
                                            <span>Saldo:</span>
                                            <span id="saldo">{{ number_format($saldo, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if(count(old('desconto')) > 0)
                                    @for($i = 0; $i < count(old('desconto')); $i++)
                                        @include('embarque.includes.desconto', [
                                          'count' => $i,
                                          'tipoDesconto' => old('desconto.' . $i . '.tipo'),
                                          'valorDesconto' => old('desconto.' . $i . '.valor')
                                        ])
                                    @endfor
                                @else
                                    @include('embarque.includes.desconto', [
                                      'count' => 0,
                                      'tipoDesconto' => 'peso',
                                      'valorDesconto' => ''
                                    ])
                                @endif

                                <div class="form-group">
                                    <label for="cond" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <button type="button" class="btn btn-default add-desconto">
                                            <span class="fa fa-plus"></span> Adicionar
                                        </button>
                                        <div style="padding-top: 7px; float: right">
                                            <span>Valor unitário:</span>
                                            <span>R$ {{ $valorUnitario }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="data_embarque" class="col-sm-3 control-label">Data do embarque</label>
                                    <div class="col-sm-5">
                                        <div class='input-group date' id='data_embarque'>
                                            <input type="text" name="data_embarque" class="form-control"  value="{{ old('data_embarque') }}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="data_pagamento" class="col-sm-3 control-label">Data prevista para pagamento</label>
                                    <div class="col-sm-5">
                                        {{--<input type="text" name="data_pagamento" class="form-control" value="{{ old('data_pagamento') }}">--}}
                                        <div class='input-group date'>
                                            <input type="text" name="data_pagamento" class="form-control"  value="{{ old('data_pagamento') }}" id="data_pagamento">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="observacao" class="col-sm-3 control-label">Observações</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="observacao" class="form-control" value="{{ old('observacao') }}">
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <hr class="line-dashed line-full"/>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-3">
                                        <button type="submit" class="btn btn-default">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /tile body -->
            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
    </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('js/chosen/chosen.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mask/jquery.mask.js') }}"></script>

<script type="text/javascript">
    $('#quantidade').mask("#.##0,00", {reverse: true});
    $('.desconto').mask("#.##0,00", {reverse: true});

    $('.date').datetimepicker({
        format: 'DD/MM/YYYY',
        showTodayButton: true
    });

    $("#data_embarque").on("dp.change", function (e) {
        var dataEmbarque = e.date;
        var dias = '{{ $condicaoPagamento }}';

        if(dias != '') {
            var dataVencimento = dataEmbarque.add(dias, 'days').format('DD/MM/YYYY');

            $('#data_pagamento').val(dataVencimento);
        }
    });

    new Vue({
        el: '#taxes',
        data: {
            taxes: []
        },
        methods: {
            addTax: function(){
                this.taxes.push({value: '', type: null});
            },
            removeTax: function(id){
                this.taxes.splice(id, 1);
            }
        }
    });

    new Vue({
        el: '#comissao_vendedor',
        data: {
            type: 'porcentagem'
        }
    });

    new Vue({
        el: '#comissao_comprador',
        data: {
            type: 'porcentagem'
        }
    });

    $(document).ready(function() {
        $('#quantidade').on('keyup', function() {
            var quantidade = parseInt($(this).val().replace(/\./g, ''));
            var quantidadePedido = parseInt('{{ $saldo }}');
            var saldo = quantidadePedido - quantidade;

            if(isNaN(saldo)) {
                $('#saldo').text(Number(quantidadePedido.toFixed(1)).toLocaleString());
            }
            else {
                $('#saldo').text(Number(saldo.toFixed(1)).toLocaleString());
            }
        });

        $('.add-desconto').on('click', function() {
            var $clone       = $('.desconto-wrapper:first').clone();
            var $lastWrapper = $('.desconto-wrapper:last');
            var count        = $lastWrapper.data('count');

            $clone.find('label').text('');
            $clone.find('.desconto').val('');
            $clone.find('.remover-desconto-wrapper').removeClass('hidden');
            $clone.attr('data-count', count + 1);
            $clone.find('.desconto-select').attr('name', 'desconto[' + (count + 1) + '][tipo]');
            $clone.find('.desconto').attr('name', 'desconto[' + (count + 1) + '][valor]');
            $lastWrapper.after($clone);
        });

        $(document).on('click', '.remover-desconto', function() {
            $(this).parents('.desconto-wrapper').remove();
        });
    });
</script>
@endpush
