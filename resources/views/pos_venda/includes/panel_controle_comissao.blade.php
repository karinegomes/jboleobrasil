<div id="controle-comissao-panel" class="panel panel-collapse collapse">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Controle de comissão</h4>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="intervalo">Período</label>
                <select class="form-control" id="intervalo" v-model="intervalo">
                    <option value="" selected>Selecionar</option>
                    @foreach($intervalos as $key => $intervalo)
                        <option value="{{ $key }}">{{ $intervalo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <a :href="controleComissaoURL" class="btn btn-default" @click="controleComissaoFiltrar">Filtrar</a>
    </div>
</div>