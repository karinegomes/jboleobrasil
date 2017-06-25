<div id="resumo-pagtos-panel" class="panel panel-collapse collapse">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Resumo de pagamentos</h4>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="intervalo-resumo">Período</label>
                <select class="form-control" id="intervalo-resumo" v-model="intervaloResumo">
                    <option value="" selected>Selecionar</option>
                    @if($intervalosPagamentos)
                        @foreach($intervalosPagamentos as $key => $intervaloPagamento)
                            <option value="{{ $key }}">{{ $intervaloPagamento }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <button @click="resumoPagamentosFiltrar" class="btn btn-default">Filtrar</button>
    </div>
</div>