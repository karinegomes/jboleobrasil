<table>
    <tbody>
    <tr>
        <th>Nome</th>
        <td><input type="text" class="form-control" value="{{ $motorista->nome }}" readonly></td>
        <th>CPF</th>
        <td><input type="text" class="form-control" value="{{ $motorista->cpf }}" readonly></td>
    </tr>
    <tr>
        <th scope="row">Telefone</th>
        <td>
            <input type="text" class="form-control" value="{{ $motorista->telefone }}" readonly>
        </td>
        <th scope="row">celular</th>
        <td>
            <input type="text" class="form-control" value="{{ $motorista->celular }}" readonly>
        </td>
    </tr>
    <tr>
        <th scope="row">Tipo de caminhão</th>
        <td>
            <input type="text"
                   class="form-control"
                   value="{{ $motorista->tipoDeCaminhao ? $motorista->tipoDeCaminhao->nome : '' }}"
                   readonly>
        </td>
        <th scope="row">Placa</th>
        <td><input type="text" class="form-control" value="{{ $motorista->placa }}" readonly></td>
    </tr>
    <tr>
        <th scope="row">Endereço</th>
        <td>
            <textarea class="form-control" rows="5" readonly>{!! $motorista->endereco !!}</textarea>
        </td>
        <th scope="row">Observações</th>
        <td>{!! nl2br($motorista->observacoes) !!}</td>
    </tr>
    </tbody>
</table>

<h3 class="custom-font"><strong>Dados Bancários</strong></h3>

<table>
    <tbody>
    <tr>
        <th>Nome do banco</th>
        <td><input type="text" class="form-control" value="{{ $motorista->dadosBancarios->nome_banco }}" readonly></td>
    </tr>
    <tr>
        <th scope="row">Favorecido</th>
        <td>
            <input type="text" class="form-control" value="{{ $motorista->dadosBancarios->favorecido }}" readonly>
        </td>
        <th scope="row">CPF/CNPJ</th>
        <td>
            <input type="text" class="form-control" value="{{ $motorista->dadosBancarios->cpf_cnpj }}" readonly>
        </td>
    </tr>
    <tr>
        <th scope="row">Agência</th>
        <td><input type="text" class="form-control" value="{{ $motorista->dadosBancarios->agencia }}" readonly></td>
        <th scope="row">Placa</th>
        <td><input type="text" class="form-control" value="{{ $motorista->dadosBancarios->conta }}" readonly></td>
    </tr>
    </tbody>
</table>