<div class="row">
    <div class="col-md-12">
        <section class="tile">

            <!-- tile header -->
            <div class="tile-header dvd dvd-btm">
                <h1 class="custom-font"><strong>Contatos</strong> Atrelados</h1>
                <ul class="controls">
                    <li>
                        <a role="button" tabindex="0" href="{{ url('/client/create?company_id='.$company->id) }}">
                            <span class="fa fa-plus mr-5"></span>Adicionar
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /tile header -->

            <!-- tile body -->
            <div class="tile-body p-0">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Telefone 1</th>
                        <th>Ramal</th>
                        <th>Telefone 2</th>
                        <th>Celular</th>
                        <th>Operadora</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($company->clients as $client)
                        <tr>
                            <td>{{$client->name}}</td>
                            <td>{{$client->position}}</td>
                            <td>{{ $client->ddd ? '(' . $client->ddd . ')' : '' }} {{$client->number}}</td>
                            <td>{{ $client->extension ? $client->extension : '-' }}</td>
                            <td>
                                @if(isset($client->telephones))
                                    @foreach($client->telephones->sortBy('number') as $telephone)
                                        @if($telephone->type == 'telefone')
                                        ({{ $telephone->ddd }}) {{ $telephone->number }}
                                            @if($telephone->extension != '')
                                                - Ramal {{ $telephone->extension }}
                                            @endif
                                            <br>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $client->mobile_ddd ? '(' . $client->mobile_ddd . ')' : '' }} {{$client->mobile_number}}</td>
                            <td>{{ $client->carrier ? $client->carrier->name : '' }}</td>
                            <td>{{$client->email}}</td>
                            <td>
                                <form class="form-inline" action="{{ url('/client/'.$client->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a class="btn btn-default btn-sm"
                                       href="{{ url('/client/'.$client->id.'/edit') }}">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    <button type="submit" class="btn btn-default btn-sm">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <!-- /tile-body -->
    </div>
</div>