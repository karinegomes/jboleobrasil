<div class="form-group condicao-pagamento-wrapper" data-count="{{ $count }}">
    <label for="cond" class="col-sm-2 control-label">Condição de Pagamento</label>
    <div class="col-sm-3">
        <div class="input-group">
            <input class="form-control dias-pagamento" name="paymethod[{{ $count }}][days]" style="width: 45px;"
                   value="{{ $days }}">
            <span class="input-group-addon">dias</span>
            <input class="form-control pagamento-comp" name="paymethod[{{ $count }}][name]" value="{{ $name }}">
        </div>
    </div>
    <div class="col-sm-2 {{ $count == 0 ? 'hidden' : '' }} remover-condicao-pagamento-wrapper">
        <button type="button" class="btn btn-danger remover-condicao-pagamento">
            <span class="fa fa-close"></span> Remover
        </button>
    </div>
</div>