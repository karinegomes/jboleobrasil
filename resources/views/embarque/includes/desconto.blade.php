<div class="form-group desconto-wrapper" data-count="{{ $count }}">
    <label for="desconto" class="col-sm-3 control-label">{{ $count == 0 ? 'Desconto' : '' }}</label>
    <div class="col-sm-5">
        <div class="col-sm-4 no-padding">
            <select name="desconto[{{ $count }}][tipo]" class="form-control desconto-select">
                <option value="peso" {{ $tipoDesconto == 'peso' ? 'selected' : '' }}>Peso</option>
                <option value="valor" {{ $tipoDesconto == 'valor' ? 'selected' : '' }}>Valor</option>
            </select>
        </div>
        <div class="col-sm-6 no-padding">
            <input type="text" name="desconto[{{ $count }}][valor]" class="form-control desconto" value="{{ $valorDesconto }}">
        </div>
        <div class="col-sm-2 no-padding {{ $count == 0 ? 'hidden' : '' }} remover-desconto-wrapper">
            <button type="button" class="btn btn-danger remover-desconto form-control">
                <span class="fa fa-close"></span> Remover
            </button>
        </div>
    </div>
</div>