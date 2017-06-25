@extends('layouts.app')

@section('entity-label', 'Compromisso')
@section('entity-url', 'appointment')
@section('action-label', 'Visualizar Compromisso')

@section('content')
    <section class="tile">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font"><strong>Compromisso - {{ $appointment->name }}</strong></h1>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form action="{{ url('appointment/' . $appointment->id) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="data"><strong>Data</strong></label>
                                    <input type="text" class="form-control" id="data" value="{{ $appointment->date }}"
                                           name="date">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hora"><strong>Hora</strong></label>
                                    <input type="text" class="form-control" id="hora" value="{{ $appointment->time }}"
                                           name="time">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status"><strong>Situação</strong></label>
                                    <select name="status_id" class="form-control" id="status">
                                        <option value="">Selecionar</option>
                                        @foreach($status as $_status)
                                            <option value="{{ $_status->id }}"
                                                    {{ ($_status->id == old('status', $appointment->status_id)) ?
                                                                            'selected' : '' }}>
                                                {{ $_status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="anotacao"><strong>Anotação</strong></label>
                                    <textarea id="anotacao" class="form-control" name="anotacao">{!! isset($appointment->interaction) ?
                                        $appointment->interaction->description : '' !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /tile body -->

    </section>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/inputmask.date.extensions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/inputmask/jquery.inputmask.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#data').inputmask('d/m/y');
        $('#hora').inputmask('h:s');
    });
</script>
@endpush