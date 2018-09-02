<div class="row">
    <div class="col-sm-12">
        <section class="tile">
            <div class="tile-header dvd dvd-btm">
                <h1 class="custom-font"><strong>Ordens de Frete</strong></h1>
            </div>
            <div class="tile-body">
                <div class="tile-widget">
                    <div class="row">
                        <div class="col-md-12">
                            <button id="visualizar-ordem-frete"
                                    class="btn btn-default ordem-frete-btn"
                                    data-url="{{ route('ordens-frete.show', '__id__') }}"
                                    disabled>
                                <span class="fa fa-search"></span> Visualizar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="ordens-frete"
                               class="table table-bordered dt-responsive display"
                               width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Data do carregamento</th>
                                <th>Previsão de descarga</th>
                                <th>Valor do frete</th>
                                <th>Cidade de origem</th>
                                <th>Cidade de destino</th>
                                <th>Adiantamento</th>
                                <th>Saldo</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>