@extends('layouts.app')

@section('entity-label', 'Cliente')
@section('entity-url', 'company')
@section('action-label', 'Cadastrar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Novo</strong> Cliente</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ url('/company') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="codigo" class="col-sm-2 control-label">Código</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="codigo" name="company[codigo]"
                                       value="{{ old('company.codigo', $codigo) }}">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Razão social</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="name" name="company[name]"
                                       value="{{ old('company.name') }}" maxlength="100">
                            </div>

                            <label for="nome_fantasia" class="col-sm-1 control-label">Nome fantasia</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="nome_fantasia" name="company[nome_fantasia]"
                                       value="{{ old('company.nome_fantasia') }}" maxlength="100">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">E-mail</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="email" name="company[email]"
                                       value="{{ old('company.email') }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Tipo</label>

                            <div class="col-sm-5">
                                <select tabindex="3" name="company[group_id]" class="form-control">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}"{{ ($group->id == old('company.group_id'))?' selected':'' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="registry" class="col-sm-2 control-label">CNPJ</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="registry" name="company[registry]"
                                       value="{{ old('company.registry') }}">
                            </div>
                            <label for="cpf" class="col-sm-1 control-label">CPF</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="cpf" name="company[cpf]"
                                       value="{{ old('company.cpf') }}">
                            </div>

                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="ie" class="col-sm-2 control-label">IE</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="ie" name="company[ie]"
                                       value="{{ old('company.ie') }}">
                            </div>

                            <label for="produtor_rural" class="col-sm-1 control-label">Produtor rural</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="produtor_rural" name="company[produtor_rural]"
                                       value="{{ old('company.produtor_rural') }}">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="nome_contato" class="col-sm-2 control-label">Nome do contato</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nome_contato" name="company[nome_contato]"
                                       value="{{ old('company.nome_contato') }}">
                            </div>

                            <label for="telefone" class="col-sm-1 control-label">Telefone</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="telefone" name="company[telefone]"
                                       value="{{ old('company.telefone') }}">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="caixa_postal" class="col-sm-2 control-label">Caixa postal</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="caixa_postal" name="company[caixa_postal]"
                                       value="{{ old('company.caixa_postal') }}">
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>

                        <div class="form-group">
                            <label for="cep" class="col-sm-2 control-label">CEP</label>
                            <div class="col-sm-10 form-inline">
                                <input type="text" id="cep" class="form-control" name="address[zip_code]" value="{{ old('address.zip_code') }}">
                                <button class="btn btn-primary" id="buscar-cep">Buscar</button>
                                <img src="{{ asset('img/loading.gif') }}" id="loading-image">
                                <span id="erro-cep"></span>
                            </div>
                        </div>

                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Endereço</label>

                            <div class="col-sm-3">
                                <input type="text" id="rua" placeholder="Rua" class="form-control" name="address[name]"
                                       value="{{ old('address.name') }}">
                            </div>
                            <div class="col-sm-1">
                                <input type="text" id="numero" placeholder="Nº" class="form-control" name="address[number]"
                                       value="{{ old('address.number') }}">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="complemento" placeholder="Complemento" class="form-control"
                                       name="address[complemento]" value="{{ old('address.complemento') }}">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" id="bairro" placeholder="Bairro" class="form-control" name="address[bairro]"
                                       value="{{ old('address.bairro') }}">
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="state" class="col-sm-2 control-label">Estado</label>

                            <div class="col-sm-4">
                                <select class="form-control mb-10" id="state" name="state_id">
                                    <option value="">Selecione um estado</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                                {{ ($state->id == old('state_id'))?' selected':'' }}
                                                data-abbreviation="{{ $state->abbreviation }}">
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="city" class="col-sm-1 control-label">Cidade</label>

                            <div class="col-sm-5">
                                <select id="city" name="address[city_id]" class="chosen-select">
                                </select>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="notes" class="col-sm-2 control-label">Observações</label>

                            <div class="col-sm-10">
                                <textarea id="notes" rows="8" class="form-control"
                                          name="company[notes]">{{ old('company.notes') }}</textarea>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="reset" class="btn btn-lightred">Limpar</button>
                                <button type="submit" class="btn btn-default">Salvar</button>
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
@endpush
@push('scripts')
<script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('js/buscar_cep.js') }}"></script>
<script type="text/javascript">
    (function () {
        const cities = {!! $cities !!};
        const $cityEl = $('#city');

        let selectedCity = {{ old('address.city_id', 0) }};

        $('#state').on('change', function () {
            $cityEl.empty();

            let selectedIndex = this.options[this.selectedIndex].value;

            (cities[selectedIndex] || []).forEach((city) => {
                $cityEl
                        .append($('<option>', {value: city.id, selected: (selectedCity === city.id)})
                                .text(city.name));
            });

            selectedCity = null;
            $cityEl.trigger('chosen:updated');
        });

        $('#state').trigger('change');
    })();

    $(document).ready(function() {
        $('#cep').inputmask('99999-999', {
            'autoUnmask': true,
            'removeMaskOnSubmit': true
        });
    });
</script>
@endpush
