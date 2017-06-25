@extends('layouts.app')

@section('entity-label', 'Contato')
@section('entity-url', 'client')
@section('action-label', 'Editar')

@section('content')
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
            <!-- tile -->
            <section class="tile">
                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Editar</strong> Contato</h1>
                </div>
                <!-- /tile header -->
                <!-- tile body -->
                <div class="tile-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ url('/client/'.$client->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nome</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name', $client->name) }}" required>
                            </div>
                            <label for="position" class="col-sm-1 control-label">Cargo</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="position" name="position"
                                       value="{{ old('position', $client->position) }}">
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">E-mail</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="email" name="email"
                                       value="{{ old('email', $client->email) }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Empresa</label>

                            <div class="col-sm-5">
                                <input type="hidden" name="company_id" value="{{ $client->company->id }}">

                                <p class="form-control-static">{{ $client->company->name }}</p>
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">DDD</label>

                            <div class="col-sm-1">
                                <input class="form-control" name="ddd" placeholder="DDD"
                                       value="{{ old('ddd', $client->ddd) }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Telefone</label>

                            <div class="col-sm-2">
                                <input class="form-control" name="number" placeholder="Telefone"
                                       value="{{ old('number', $client->number) }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Ramal</label>

                            <div class="col-sm-2">
                                <input class="form-control" name="extension" placeholder="Ramal"
                                       value="{{ old('extension', $client->extension) }}">
                            </div>
                        </div>
                        <hr class="line-dashed line-full"/>
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">DDD</label>

                            <div class="col-sm-1">
                                <input class="form-control" name="mobile_ddd" placeholder="DDD"
                                       value="{{ old('mobile_ddd', $client->mobile_ddd) }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Celular</label>

                            <div class="col-sm-2">
                                <input class="form-control" name="mobile_number" placeholder="Celular"
                                       value="{{ old('mobile_number', $client->mobile_number) }}">
                            </div>
                            <label for="company" class="col-sm-1 control-label">Operadora</label>

                            <div class="col-sm-2">
                                <select class="form-control" name="carrier_id">
                                    <option value="" {{ $client->carrier_id == null ? 'selected' : '' }}>Selecionar</option>
                                    @foreach($carriers as $carrier)
                                        <option value="{{ $carrier->id }}"{{ $carrier->id == old('carrier_id', $client->carrier_id) ? ' selected' : '' }}>
                                            {{ $carrier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @foreach($client->telephones as $index => $telephone)
                            <hr class="line-dashed line-full"/>
                            <input type="hidden" class="id-telefone-removido" name="id_telefone_removido[]" value="">

                            <div class="form-group telefone-wrapper">
                                <input type="hidden" class="id-telefone" name="id_telefone[]" value="{{ $telephone->id }}">

                                <label for="company" class="col-sm-2 control-label">DDD</label>
                                <div class="col-sm-1">
                                    <input class="form-control" name="telefone_adicional_ddd_salvo[]" placeholder="DDD"
                                           value="{{ old('telefone_adicional_ddd_salvo.' . $index, $telephone->ddd) }}" required>
                                </div>

                                <label for="company" class="col-sm-1 control-label">
                                    {{ ucfirst($telephone->type) }}
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control" name="telefone_adicional_salvo[]" placeholder="{{ ucfirst($telephone->type) }}"
                                           value="{{ old('telefone_adicional_salvo.' . $index, $telephone->number) }}" required>
                                </div>

                                <input type="hidden" name="tipo_salvo[]" value="{{ $telephone->type }}">

                                <label for="company" class="col-sm-1 control-label">
                                    {{ $telephone->type == 'telefone' ? 'Ramal' : 'Operadora' }}
                                </label>
                                <div class="col-sm-2">
                                    @if($telephone->type == 'telefone')
                                        <input class="form-control" name="operadora_ramal_adicional_salvo[]" placeholder="Ramal"
                                               value="{{ old('extension', $telephone->extension) }}">
                                    @else
                                        <select class="form-control" name="operadora_ramal_adicional_salvo[]">
                                            <option value="" {{ old('operadora_ramal_adicional_salvo.' . $index, $telephone->carrier_id) == null ? 'selected' : '' }}>Selecionar</option>
                                            @foreach($carriers as $carrier)
                                                <option value="{{ $carrier->id }}" {{ old('operadora_ramal_adicional_salvo.' . $index, $telephone->carrier_id) == $carrier->id ? 'selected' : '' }}>
                                                    {{ $carrier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <button type="reset" class="btn btn-lightred remover-telefone">Remover</button>
                                </div>
                            </div>
                        @endforeach
                        <hr class="line-dashed line-full"/>

                        @for($i = 0; $i < count(old('telefone_adicional_ddd')); $i++)
                            <div class="form-group telefone-wrapper">
                                <label for="company" class="col-sm-1 control-label">DDD</label>
                                <div class="col-sm-1">
                                    <input type="number" class="form-control" name="telefone_adicional_ddd[]" placeholder="DDD" value="{{ old('telefone_adicional_ddd.' . $i) }}" maxlength="2">
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control tipo-telefone" name="tipo_telefone[]">
                                        <option value="telefone" {{ old('tipo_telefone.' . $i) == 'telefone' ? 'selected' : '' }}>Telefone</option>
                                        <option value="celular" {{ old('tipo_telefone.' . $i) == 'celular' ? 'selected' : '' }}>Celular</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="tel" class="form-control" name="telefone_adicional[]" placeholder="Telefone" value="{{ old('telefone_adicional.' . $i) }}" maxlength="10">
                                </div>
                                <label for="company" class="col-sm-1 control-label operadora-ramal-label">
                                    {{ old('tipo_telefone.' . $i) == 'telefone' ? 'Ramal' : 'Operadora' }}
                                </label>
                                <div class="col-sm-2 operadora-ramal-wrapper">
                                    @if(old('tipo_telefone.' . $i) == 'telefone')
                                        <input type="number" class="form-control" name="operadora_ramal_adicional[]" placeholder="Ramal" value="{{ old('operadora_ramal_adicional.' . $i) }}">
                                    @else
                                        <select class="form-control" name="operadora_ramal_adicional[]">
                                            <option value="" {{ old('operadora_ramal_adicional.' . $i) == '' ? 'selected' : '' }}>Selecionar</option>
                                            @foreach($carriers as $carrier)
                                                <option value="{{ $carrier->id }}"{{ $carrier->id == old('operadora_ramal_adicional.' . $i) ? ' selected' : '' }}>
                                                    {{ $carrier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <button type="reset" class="btn btn-lightred remover-telefone">Remover</button>
                                </div>
                            </div>
                            <hr class="line-dashed line-full"/>
                        @endfor

                        <div class="form-group" id="adicionar-telefone-wrapper">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary mb-10" id="adicionar-telefone">Adicionar telefone</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <label class="checkbox checkbox-custom-alt">
                                    <input type="checkbox" name="main" value="1"{{ old('main') == 1 ? ' checked' : '' }}><i></i>
                                    Contato principal
                                </label>
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

<script>
    $(document).ready(function() {
        $('#adicionar-telefone').on('click', function() {
            $('#adicionar-telefone-wrapper').before(
                    '<div class="form-group telefone-wrapper">\
                        <label for="company" class="col-sm-1 control-label">DDD</label>\
                        <div class="col-sm-1">\
                            <input type="number" class="form-control" name="telefone_adicional_ddd[]" placeholder="DDD" value="" required>\
                        </div>\
                        <div class="col-sm-2">\
                            <select class="form-control tipo-telefone" name="tipo_telefone[]">\
                                <option value="telefone">Telefone</option>\
                                <option value="celular">Celular</option>\
                            </select>\
                        </div>\
                        <div class="col-sm-2">\
                            <input type="tel" class="form-control" name="telefone_adicional[]" placeholder="Telefone" value="" required>\
                        </div>\
                        <label for="company" class="col-sm-1 control-label operadora-ramal-label">Ramal</label>\
                        <div class="col-sm-2 operadora-ramal-wrapper">\
                            <input type="number" class="form-control" name="operadora_ramal_adicional[]" placeholder="Ramal" value="">\
                        </div>\
                        <div class="col-sm-2">\
                            <button type="reset" class="btn btn-lightred remover-telefone">Remover</button>\
                        </div>\
                    </div>\
                    <hr class="line-dashed line-full"/>');
        });

        $(document).on('change', '.tipo-telefone', function() {
            var $wrapper = $(this).parents('.telefone-wrapper');

            if($(this).val() == 'celular') {
                $wrapper.find('.operadora-ramal-label').text('Operadora');
                $wrapper.find('.operadora-ramal-wrapper').html(
                        '<select class="form-control" name="operadora_ramal_adicional[]">\
                            <option value="">Selecionar</option>\
                        @foreach($carriers as $carrier)
                                <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>\
                            @endforeach
                            </select>');
            }
            else if($(this).val() == 'telefone') {
                $wrapper.find('.operadora-ramal-label').text('Ramal');
                $wrapper.find('.operadora-ramal-wrapper').html('<input class="form-control" name="operadora_ramal_adicional[]" placeholder="Ramal" value="">');
            }
        });

        $(document).on('click', '.remover-telefone', function() {
            var $wrapper = $(this).parents('.telefone-wrapper');
            var $linha = $wrapper.next();

            $wrapper.prev().val($wrapper.find('.id-telefone').val());
            $wrapper.remove();
            $linha.remove();
        });
    });
</script>
@endpush
