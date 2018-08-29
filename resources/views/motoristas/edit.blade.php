@extends('layouts.app')

@section('entity-label', 'Motorista')
@section('entity-url', 'motoristas')
@section('action-label', $motorista->id ? 'Editar' : 'Cadastrar')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="tile">
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Cadastrar</strong> Motorista</h1>
                </div>
                <div class="tile-body">
                    <form method="post"
                          action="{{ $motorista->id ? route('motoristas.update', $motorista) : route('motoristas.store') }}">

                        @if($motorista->id)
                            <input type="hidden" name="_method" value="PUT">
                        @endif

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nome" class="control-label">Nome</label>
                                    <input type="text"
                                           class="form-control"
                                           id="nome" name="nome"
                                           value="{{ old('nome', $motorista->nome) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cpf" class="control-label">CPF</label>
                                    <input type="text"
                                           class="form-control"
                                           id="cpf"
                                           name="cpf"
                                           value="{{ old('cpf', $motorista->cpf) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telefone" class="control-label">Telefone</label>
                                    <input type="text"
                                           class="form-control"
                                           id="telefone"
                                           name="telefone"
                                           value="{{ old('telefone', $motorista->telefone) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="celular" class="control-label">Celular</label>
                                    <input type="text"
                                           class="form-control"
                                           id="celular"
                                           name="celular"
                                           value="{{ old('celular', $motorista->celular) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tipo_de_caminhao_id" class="control-label">Tipo de caminhão</label>
                                    <select name="tipo_de_caminhao_id" id="tipo_de_caminhao_id" class="form-control">
                                        <option value="">Selecionar...</option>
                                        @foreach($tiposCaminhao as $tipoCaminhao)
                                            <option value="{{ $tipoCaminhao->id }}"
                                                    {{ old('tipo_de_caminhao_id', $motorista->tipo_de_caminhao_id) == $tipoCaminhao->id ? 'selected' : '' }}>
                                                {{ $tipoCaminhao->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="placa" class="control-label">Placa</label>
                                    <input type="text"
                                           class="form-control"
                                           id="placa"
                                           name="placa"
                                           value="{{ old('placa', $motorista->placa) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="endereco" class="control-label">Endereço</label>
                                    <textarea name="endereco"
                                              class="form-control"
                                              rows="5"
                                    >{{ old('endereco', $motorista->endereco) }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="observacoes" class="control-label">Observações</label>
                                    <textarea name="observacoes"
                                              class="form-control"
                                              rows="5"
                                    >{{ old('observacoes', $motorista->observacoes) }}</textarea>
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
                                           value="{{ old('dados_bancarios.nome_banco', $motorista->id ? $motorista->dadosBancarios->nome_banco : null) }}">
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
                                           value="{{ old('dados_bancarios.favorecido', $motorista->id ? $motorista->dadosBancarios->favorecido : null) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cpf_cnpj" class="control-label">CPF/CNPJ</label>
                                    <input type="text"
                                           class="form-control"
                                           id="cpf_cnpj"
                                           name="dados_bancarios[cpf_cnpj]"
                                           value="{{ old('dados_bancarios.cpf_cnpj', $motorista->id ? $motorista->dadosBancarios->cpf_cnpj : null) }}">
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
                                           value="{{ old('dados_bancarios.agencia', $motorista->id ? $motorista->dadosBancarios->agencia : null) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="conta" class="control-label">Conta</label>
                                    <input type="text"
                                           class="form-control"
                                           id="conta"
                                           name="dados_bancarios[conta]"
                                           value="{{ old('dados_bancarios.conta', $motorista->id ? $motorista->dadosBancarios->conta : null) }}">
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