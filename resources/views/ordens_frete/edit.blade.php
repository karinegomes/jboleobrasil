@extends('layouts.app')

@section('entity-label', 'Ordens de Frete')
@section('entity-url', 'ordens-frete')
@section('action-label', $ordemFrete->id ? 'Editar' : 'Cadastrar')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="tile">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font">
                        <strong>{{ $ordemFrete->id ? 'Editar' : 'Cadastrar' }}</strong> Ordem de Frete
                    </h1>
                </div>
                <div class="tile-body">
                    <form method="post"
                          action="{{ $ordemFrete->id ? route('ordens-frete.update', $ordemFrete) : route('ordens-frete.store') }}">

                        @if($ordemFrete->id)
                            <input type="hidden" name="_method" value="PUT">
                        @endif

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="motorista_id" class="control-label">Motorista</label>
                                    <select name="motorista_id"
                                            id="motorista_id"
                                            class="form-control chosen-select"
                                            data-placeholder="Selecione o motorista...">
                                        <option value=""
                                                {{ old('motorista_id', $ordemFrete->motorista_id) == '' ? 'selected' : '' }}
                                        ></option>
                                        @foreach($motoristas as $motorista)
                                            <option value="{{ $motorista->id }}"
                                                    data-url="{{ route('ajax.motoristas.dados-bancarios', $motorista) }}"
                                                    {{ old('motorista_id', $ordemFrete->motorista_id) == $motorista->id ? 'selected' : '' }}
                                            >{{ $motorista->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="data_carregamento" class="control-label">
                                                Data do carregamento
                                            </label>
                                            <div class='input-group date' id='sell_date'>
                                                <input type="text"
                                                       class="form-control"
                                                       id="data_carregamento"
                                                       name="data_carregamento"
                                                       value="{{ old('data_carregamento', $ordemFrete->data_carregamento ? $ordemFrete->data_carregamento->format('d/m/Y') : null) }}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="previsao_descarga" class="control-label">
                                                Previsão de descarga
                                            </label>
                                            <div class='input-group date'>
                                                <input type="text"
                                                       class="form-control"
                                                       id="previsao_descarga"
                                                       name="previsao_descarga"
                                                       value="{{ old('previsao_descarga', $ordemFrete->previsao_descarga ? $ordemFrete->previsao_descarga->format('d/m/Y') : null) }}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cidade_origem" class="control-label">Cidade de origem</label>
                                    <input type="text"
                                           class="form-control"
                                           id="cidade_origem"
                                           name="cidade_origem"
                                           value="{{ old('cidade_origem', $ordemFrete->cidade_origem) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cidade_destino" class="control-label">Cidade de destino</label>
                                    <input type="text"
                                           class="form-control"
                                           id="cidade_destino"
                                           name="cidade_destino"
                                           value="{{ old('cidade_destino', $ordemFrete->cidade_destino) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="valor_frete" class="control-label">Valor do frete</label>
                                    <input type="text"
                                           class="form-control"
                                           id="valor_frete"
                                           name="valor_frete"
                                           value="{{ old('valor_frete', $ordemFrete->valor_frete) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="peso" class="control-label">Peso</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="peso"
                                                   name="peso"
                                                   value="{{ old('peso', $ordemFrete->peso) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="measure_id" class="control-label">Medida</label>
                                            <select name="measure_id"
                                                    id="measure_id"
                                                    class="form-control chosen-select"
                                                    data-placeholder="Selecione a medida...">
                                                <option value=""
                                                        {{ old('measure_id', $ordemFrete->measure_id) == '' ? 'selected' : '' }}
                                                ></option>
                                                @foreach($measures as $measure)
                                                    <option value="{{ $measure->id }}"
                                                            {{ old('measure_id', $ordemFrete->measure_id) == $measure->id ? 'selected' : '' }}
                                                    >{{ $measure->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="adiantamento" class="control-label">Adiantamento</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="adiantamento"
                                               name="adiantamento"
                                               value="{{ old('adiantamento', $ordemFrete->adiantamento) }}">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="saldo" class="control-label">Saldo</label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control"
                                               id="saldo"
                                               name="saldo"
                                               value="{{ old('saldo', $ordemFrete->saldo) }}">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="custom-font"><strong>Dados Bancários</strong></h3>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome_banco" class="control-label">Nome do banco</label>
                                    <input type="text"
                                           class="form-control"
                                           id="nome_banco"
                                           name="dados_bancarios[nome_banco]"
                                           value="{{ old('dados_bancarios.nome_banco', $ordemFrete->id ? $ordemFrete->dadosBancarios->nome_banco : null) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="favorecido" class="control-label">Favorecido</label>
                                    <input type="text"
                                           class="form-control"
                                           id="favorecido"
                                           name="dados_bancarios[favorecido]"
                                           value="{{ old('dados_bancarios.favorecido', $ordemFrete->id ? $ordemFrete->dadosBancarios->favorecido : null) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cpf_cnpj" class="control-label">CPF/CNPJ</label>
                                    <input type="text"
                                           class="form-control"
                                           id="cpf_cnpj"
                                           name="dados_bancarios[cpf_cnpj]"
                                           value="{{ old('dados_bancarios.cpf_cnpj', $ordemFrete->id ? $ordemFrete->dadosBancarios->cpf_cnpj : null) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="agencia" class="control-label">Agência</label>
                                    <input type="text"
                                           class="form-control"
                                           id="agencia"
                                           name="dados_bancarios[agencia]"
                                           value="{{ old('dados_bancarios.agencia', $ordemFrete->id ? $ordemFrete->dadosBancarios->agencia : null) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="conta" class="control-label">Conta</label>
                                    <input type="text"
                                           class="form-control"
                                           id="conta"
                                           name="dados_bancarios[conta]"
                                           value="{{ old('dados_bancarios.conta', $ordemFrete->id ? $ordemFrete->dadosBancarios->conta : null) }}">
                                </div>
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="text-right">
                            <button type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(".chosen-select").chosen({
                allow_single_deselect: true
            });

            $('.date').datetimepicker({
                format: 'DD/MM/YYYY',
                showTodayButton: true
            });

            $('#motorista_id').on('change', function () {
                var id = $(this).val();
                var url = $(this).find(':selected').data('url');

                if (url !== undefined) {
                    $.ajax({
                        url: url,
                        success: function (response) {
                            var dadosBancarios = response.dadosBancarios;

                            $('#nome_banco').val(dadosBancarios.nome_banco);
                            $('#favorecido').val(dadosBancarios.favorecido);
                            $('#cpf_cnpj').val(dadosBancarios.cpf_cnpj);
                            $('#agencia').val(dadosBancarios.agencia);
                            $('#conta').val(dadosBancarios.conta);
                        }
                    });
                } else {
                    $('#nome_banco').val('');
                    $('#favorecido').val('');
                    $('#cpf_cnpj').val('');
                    $('#agencia').val('');
                    $('#conta').val('');
                }
            });

            $('#adiantamento').on('keyup', function () {
                var adiantamento = $(this).val();

                if (!isNaN(adiantamento)) {
                    var saldo = 100 - adiantamento;

                    $('#saldo').val(saldo);
                } else {
                    $('#saldo').val('');
                }
            });
        });
    </script>
@endpush