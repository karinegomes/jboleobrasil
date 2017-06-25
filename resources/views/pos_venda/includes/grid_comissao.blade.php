<script type="text/x-template" id="grid-comissao">
    <div class="col-md-3 columns left-column p-0">
        <section class="h-50 bb-color2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active"><a>Períodos</a></li>
                <li role="presentation">
                    <a href="#" v-for="periodo in periodos" v-on:click="recuperarClientes(periodo)">@{{ periodo.nome }}</a>
                </li>
            </ul>
        </section>
        <section class="h-50">
            <div class="title-info">Informações</div>
            <div class="body-info" v-if="info">
                <p>Total em cobrança: R$ @{{ info.cobranca }}</p>
                <p>AgroSD: R$ @{{ info.agroSD }}</p>
                <p>Silas: R$ @{{ info.silas }}</p>
                <p>Dayane: R$ @{{ info.dayane }}</p>
                <p>Total pago: R$ @{{ info.pago }}</p>
            </div>
        </section>
    </div>
    <div class="col-md-9 p-0 columns">
        <section class="component h-50 bb-color2">
            <div class="p-15 bb-color" v-if="periodoSelecionado">
                <h3 class="mt-0 mb-0 mr-20" style="display: inline-block; vertical-align: middle">Período: @{{ periodoSelecionado.nome }}</h3>
                <button v-on:click="imprimir" class="btn btn-default" :disabled="!clienteSelecionado">
                    <span class="fa fa-file-pdf-o"></span> Imprimir relatório
                </button>
            </div>
            <div class="table-responsive wrapper">
                <table class="table" v-if="clientes">
                    <thead>
                    <tr class="header">
                        <th v-for="colunaCliente in colunasClientes"
                            v-on:click="sortBy(colunaCliente.key)"
                            :class="{active: sortKey == colunaCliente.key}">
                            @{{ colunaCliente.label }}
                            <span class="fa" :class="sortOrders[colunaCliente.key] > 0 ? 'fa-caret-down' : 'fa-caret-up'"></span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="cliente in clientes | filterBy filterKey | orderBy sortKey sortOrders[sortKey]"
                        v-on:click="recuperarEmbarques(cliente)"
                        :class="{info: clienteSelecionado == cliente}">
                        <td v-for="colunaCliente in colunasClientes">
                            @{{typeof colunaCliente.key === 'string' ? cliente[colunaCliente.key] : colunaCliente.key(cliente)}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="component h-50">
            <div v-if="embarques">
                <div class="p-15">
                    <h3 class="mt-0 mb-0 mr-20" style="display: inline-block; vertical-align: middle">Cliente: @{{ clienteSelecionado.nome_fantasia }}</h3>
                    <button v-on:click="incluirBaixa" class="btn btn-default" :disabled="!embarqueSelecionado || embarqueSelecionado.status == 'pago'">
                        <span class="fa fa-plus mr-5"></span> Incluir baixa
                    </button>
                    <button v-on:click="visualizarBaixa" class="btn btn-default" :disabled="!embarqueSelecionado || embarqueSelecionado.status == 'nao_pago'">
                        <span class="fa fa-pencil mr-5"></span> Visualizar baixa
                    </button>
                    <button v-on:click="editarBaixa" class="btn btn-default" :disabled="!embarqueSelecionado || embarqueSelecionado.status == 'nao_pago'">
                        <span class="fa fa-pencil mr-5"></span> Editar baixa
                    </button>
                    <button v-on:click="excluirBaixa" class="btn btn-default" :disabled="!embarqueSelecionado || embarqueSelecionado.status == 'nao_pago'">
                        <span class="fa fa-trash mr-5"></span> Excluir baixa
                    </button>
                </div>
                <div class="table-responsive wrapper">
                    <table class="table bt-color table-embarques">
                        <thead>
                        <tr class="header">
                            <th v-for="colunaEmbarque in colunasEmbarques"
                                :class="{active: sortKeyEmbarque == colunaEmbarque.key}"
                                v-on:click="sortByEmbarques(colunaEmbarque.key)">
                                @{{ colunaEmbarque.label }}
                                <span class="fa" :class="sortOrdersEmbarques[colunaEmbarque.key] > 0 ? 'fa-caret-down' : 'fa-caret-up'"></span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="embarque in embarques | filterBy filterKey | orderBy sortKeyEmbarque sortOrdersEmbarques[sortKeyEmbarque]"
                            v-on:click="setEmbarqueSelecionado(embarque)" {{-- TODO --}}
                            :class="{ info: embarqueSelecionado == embarque }">
                            <td v-for="colunaEmbarque in colunasEmbarques">
                                @{{typeof colunaEmbarque.key === 'string' ? embarque[colunaEmbarque.key] : colunaEmbarque.key(embarque)}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</script>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
        padding: 0.5em 1.3em;
        text-align: left;
    }
    th {
        white-space: nowrap;
        -webkit-user-select: none; /* webkit (safari, chrome) browsers */
        -moz-user-select: none; /* mozilla browsers */
        -khtml-user-select: none; /* webkit (konqueror) browsers */
        -ms-user-select: none; /* IE10+ */
    }
    .component{
        line-height: 1.5em;
        margin: 0 auto;
        overflow: auto;
    }
    .sticky-wrap {
        overflow: auto;
        position: relative;
        width: 100%;
        max-height: 50vh;
    }
    .sticky-wrap .sticky-thead,
    .sticky-wrap .sticky-col,
    .sticky-wrap .sticky-intersect {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 50;
        width: auto; /* Prevent table from stretching to full size */
    }
    .sticky-wrap .sticky-thead {
        z-index: 100;
        width: 100%; /* Force stretch */
    }
    .sticky-wrap .sticky-intersect {
        display: block;
        z-index: 150;

    }
    .sticky-wrap .sticky-intersect th {
        background-color: #666;
        color: #eee;
    }
    .sticky-wrap td,
    .sticky-wrap th {
        box-sizing: border-box;
        cursor: pointer;
        position: relative;
        background-color: #acacac;
    }
    .sticky-wrap td > span{
        position: absolute;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        left: 1.5em;
        right: 1.5em;
        top: 0.6em;
    }
</style>
<script src="{{ asset('js/sticky-header/sticky-header.js') }}"></script>
<script src="{{ asset('js/vue-resource.min.js') }}"></script>

<script type="text/javascript">
    Vue.component('comissao-grid', {
        template: '#grid-comissao',
        props: {
            /*data: Array,
            columns: Array,
            entity: String,
            filterKey: String,
            selected: Object,
            clientes: Array,
            cliente: Object,
            intervalo: String,
            total: String*/
            periodos: Array,
            periodoSelecionado: Object,
            clientes: Array,
            colunasClientes: Array,
            clienteSelecionado: Object,
            embarques: Array,
            colunasEmbarques: Array,
            embarqueSelecionado: Object,
            info: Object
        },
        data: function () {
            var sortOrders = {};
            var sortOrdersEmbarques = {};

            this.colunasClientes.forEach(function (colunaCliente) {
                sortOrders[colunaCliente.key] = 1;
            });

            this.colunasEmbarques.forEach(function(colunaEmbarque) {
                sortOrdersEmbarques[colunaEmbarque.key] = 1;
            });

            return {
                sortKey: '',
                sortOrders: sortOrders,
                sortKeyEmbarque: '',
                sortOrdersEmbarques: sortOrdersEmbarques
            };
        },
        methods: {
            sortBy: function(key){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            sortByEmbarques: function(key) {
                this.sortKeyEmbarque = key;
                this.sortOrdersEmbarques[key] = this.sortOrdersEmbarques[key] * -1;
            },
            recuperarClientes: function (periodo) {
                //this.periodoSelecionado = periodo;
                this.$set('periodoSelecionado', periodo);

                this.clientes = null;
                this.embarques = null;
                this.info = null;

                console.log(this.periodoSelecionado);

                this.$http.get(APP_URL + '/ajax/clientes/comissao/' + this.periodoSelecionado.periodo)
                    .then(function (results){
                        console.log(results);

                        this.clientes = results.body.clientes;
                        this.info = results.body.info;
                    }, function (response) {
                        console.log('failed');
                    });
            },
            recuperarEmbarques: function(cliente) {
                this.clienteSelecionado = cliente;

                this.$http.get(APP_URL + '/ajax/pos-venda/controle-pagamento', {
                    params: {
                        idEmpresa: cliente.id,
                        periodo: this.periodoSelecionado.periodo
                    }
                }).then(function (results){
                    this.embarques = results.body;
                }, function (response) {
                    console.log('failed');
                });
            },
            setEmbarqueSelecionado: function(embarque) {
                this.embarqueSelecionado = embarque;
            },
            incluirBaixa: function() {
                const idEmbarque = this.embarqueSelecionado.id;
                const idCliente = this.embarqueSelecionado.idCliente;

                location.href = '{{ url('pos-venda') }}/' + idCliente + '/controle-pagamento/' + idEmbarque + '/baixa/criar';
            },
            visualizarBaixa: function() {
                const idBaixa = this.embarqueSelecionado.idBaixa;

                location.href = '{{ url('baixa') }}/' + idBaixa + '/visualizar';
            },
            editarBaixa: function() {
                const idEmbarque = this.embarqueSelecionado.id;
                const idCliente = this.embarqueSelecionado.idCliente;

                location.href = '{{ url('pos-venda') }}/' + idCliente + '/controle-pagamento/' + idEmbarque + '/baixa/editar';
            },
            excluirBaixa: function() {
                const idBaixa = this.embarqueSelecionado.idBaixa;
                const idCliente = this.embarqueSelecionado.idCliente;

                const r = confirm("Tem certeza que deseja excluir a baixa?");

                if (r == true) {
                    $.ajax({
                        type: "DELETE",
                        url: APP_URL + '/baixa/' + idBaixa,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            location.href = result.redirectUrl;
                        },
                        error: function(response, textStatus, errorThrown) {
                            var error = response.responseJSON;

                            $('.alert-danger').append('<span>' + error + '</span>');
                            $('.alert-danger').removeClass('hidden');
                        }
                    });
                }
            },
            imprimir: function() {
                const id = this.clienteSelecionado.id;
                const periodo = this.periodoSelecionado.periodo;

                window.open(`{{ url('pos-venda') }}/relatorio/${id}?periodo=${periodo}`, '_blank');
            }
        },
        ready: function(){
            //StickyHeader(this.$els.datagrid);
        }
        /*methods: {
            sortBy: function(key){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            setSelected(entry){
                this.$set('selected', entry);
            },
            clienteClick: function(cliente) {
                console.log(this.intervalo);

                this.cliente = cliente;
                this.$set('data', null);

                this.$http.get(APP_URL + '/baixa/' + this.cliente.id, {
                    params: {
                        intervalo: this.intervalo
                    }
                })
                    .then(function (results){
                        console.log(results);
                        this.$set('data', results.body.baixas);
                        this.$set('total', results.body.total);
                        // console.log('success');
                    }, function (response) {
                        console.log('failed');
                    });
            }
        }*/
    })
</script>