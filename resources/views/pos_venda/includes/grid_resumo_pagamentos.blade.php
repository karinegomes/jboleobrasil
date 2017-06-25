<script type="text/x-template" id="grid-template">
    <div class="col-md-3 pt-15 pb-15 columns left-column">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a>Clientes</a></li>
            <li role="presentation" v-for="cliente in clientes">
                <a href="#" v-on:click="clienteClick(cliente)">@{{ cliente.nome_fantasia }}</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9 pt-15 pb-15 columns">
        <section class="component">
            <h3 class="mt-0" v-if="cliente">Cliente: @{{ cliente.nome_fantasia }}</h3>
            <div class="table-responsive wrapper">
                <table class="table" v-el:datagrid v-if="data">
                    <thead>
                    <tr class="header">
                        <th v-for="column in columns"
                        v-on:click="sortBy(column.key)"
                        :class="{active: sortKey == column.key}">
                        @{{column.label}}
                        <span class="fa"
                              :class="sortOrders[column.key] > 0 ? 'fa-caret-down' : 'fa-caret-up'">
          </span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="
        entry in data
        | filterBy ]y
        | orderBy sortKey sortOrders[sortKey]"
                    @click="setSelected(entry)"
                    :class="{info: selected == entry}">
                    <td v-for="column in columns">
                        @{{typeof column.key === 'string' ? entry[column.key] : column.key(entry)}}
                    </td>
                    </tr>
                    <tr>
                        <td v-for="n in columns.length">
                            @{{ n == columns.length - 1 ? total : '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
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
        overflow: hidden;
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
    Vue.component('grid-resumo-pagamentos', {
        template: '#grid-template',
        props: {
            data: Array,
            columns: Array,
            entity: String,
            filterKey: String,
            selected: Object,
            clientes: Array,
            cliente: Object,
            intervalo: String,
            total: String
        },
        data: function () {
            var sortOrders = {};
            this.columns.forEach(function (column) {
                sortOrders[column.key] = 1;
            });
            return {
                sortKey: '',
                sortOrders: sortOrders
            };
        },
        ready: function(){
            StickyHeader(this.$els.datagrid);
        },
        methods: {
            sortBy: function(key){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            setSelected(entry){
                this.$set('selected', entry);
            },
            clienteClick: function(cliente) {
                this.cliente = cliente;
                this.$set('data', null);

                this.$http.get(APP_URL + '/baixa/' + this.cliente.id, {
                    params: {
                        intervalo: this.intervalo
                    }
                })
                    .then(function (results){
                        this.$set('data', results.body.baixas);
                        this.$set('total', results.body.total);
                        // console.log('success');
                    }, function (response) {
                        console.log('failed');
                    });
            }
        }
    })
</script>