<div id="search-panel" class="panel panel-collapse collapse">
    <div class="panel-body">
        <form class="form" id="filtro">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Período</label>
                    <div class="input-group data">
                        <span class="input-group-addon">de</span>
                        <input name="search[min_date]" type="text" class="form-control" v-model="minDate">
                        <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>&nbsp;</label>
                    <div class="input-group data">
                        <span class="input-group-addon">até</span>
                        <input name="search[max_date]" type="text" class="form-control" v-model="maxDate">
                        <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Vendedor</label>
                    <select name="search[vendedor]" class="form-control" v-model="vendedor">
                        <option value="todos">Todos</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome_fantasia }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Comprador</label>
                    <select name="search[comprador]" class="form-control" v-model="comprador">
                        <option value="todos">Todos</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome_fantasia }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-default">Filtrar</button>
            <a role="button" data-toggle="modal" data-target="#modal-cobranca-periodo" class="btn btn-default">
                Salvar cobrança do período
            </a>
        </form>
    </div>
</div>