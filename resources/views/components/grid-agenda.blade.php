<script type="text/x-template" id="grid-template">
    <section class="component">
        <div class="table-responsive wrapper">
            <table class="table" v-el:datagrid>
                <thead>
                <tr class="header">
                    <th v-for="column in columns"
                        @click="sortBy(column.key)"
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
        | filterBy filterKey
        | orderBy sortKey sortOrders[sortKey]"
                    @click="setSelected(entry)"
                    :class="{info: selected == entry}">
                    <td v-for="column in columns" :class="pintarFundo(entry)">
                        @{{typeof column.key === 'string' ? entry[column.key] : column.key(entry)}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
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
    .yellow {
        background-color: #FFEB3B !important;
    }

    .red {
        background-color: #f44336 !important;
    }
</style>
<script src="{{ asset('js/sticky-header/sticky-header.js') }}"></script>
<script type="text/javascript">
    Vue.component('demo-grid', {
        template: '#grid-template',
        props: {
            data: Array,
            columns: Array,
            entity: String,
            filterKey: String,
            selected: Object
        },
        data: function () {
            var sortOrders = {};
            this.columns.forEach(function (column) {
                sortOrders[column.key] = 1;
            });
            return {
                sortKey: '',
                sortOrders: sortOrders,
                teste: true
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
            pintarFundo(entry) {
                if(entry.proximo_compromisso !== null) {
                    if (entry.pintar_amarelo) {
                        return 'yellow';
                    }
                }
            }
        }
    })
</script>
