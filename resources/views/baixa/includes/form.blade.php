<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
    <label class="col-sm-3 control-label">Data do pagamento</label>
    <div class="col-sm-9">
        <div class='input-group date'>
            <input type="text" class="form-control" name="data_pagamento" value="{{ old('data_pagamento', $edit ? $baixa->data_pagamento->format('d/m/Y') : '') }}">
            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Valor</label>
    <div class="col-sm-9">
        <input type="text" id="valor" class="form-control" name="valor" value="{{ old('valor', $edit ? $baixa->valor :  $valor) }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Observação</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="observacao" value="{{ old('observacao', $edit ? $baixa->observacao : '') }}">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-3">
        <button type="submit" class="btn btn-default">Salvar</button>
    </div>
</div>