<div class="modal fade" id="modal-cobranca-periodo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Nova cobrança do período</h3>
            </div>
            <div class="modal-body">
                <form>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="nome">Nome da cobrança</label>
                        <input type="email" class="form-control" id="nome" name="nome" v-model="nome">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" v-on:click="salvarCobranca">
                    <i class="fa fa-arrow-right"></i> Salvar
                </button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal">
                    <i class="fa fa-arrow-left"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>