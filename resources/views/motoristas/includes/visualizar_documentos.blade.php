<div class="row">
    <div class="col-md-12">
        <section class="tile" id="grid">
            <div class="tile-header dvd dvd-btm">
                <h1 class="custom-font"><strong>Visualizar</strong> Documentos</h1>
            </div>
            <!-- /tile header -->
            <div class="tile-widget">
                <div class="row">
                    <div class="col-sm-10">
                        <button type="button" @click="read" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-search"></span> Visualizar
                        </button>
                        <button type="button" @click="remove" class="btn btn-default btn-sm" :disabled="!selected">
                            <span class="fa fa-trash"></span> Apagar
                        </button>
                    </div>
                    <div class="col-sm-10">
                        <form class="form-inline"
                              action="{{ route('motoristas.documents.store', $motorista) }}"
                              method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Arquivo</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Tipo de Documento</label>
                                <select class="form-control" name="doctype_id">
                                    @foreach($doctypes as $doctype)
                                        <option value="{{ $doctype->id }}">{{ $doctype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- tile body -->
            <div class="tile-body p-0">
                <demo-grid
                        :data="gridData"
                        :selected.sync="selected"
                        :columns="gridColumns"
                        :filter-key="searchQuery">
                </demo-grid>
            </div>
        </section>
    </div>
    <!-- /col -->
</div>