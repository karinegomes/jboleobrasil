<table class="ordem-frete-dados">
    <tbody>
    <tr>
        <th width="25%">Motorista</th>
        <td width="25%"><input type="text" class="form-control" value="{{ $ordemFrete->motorista->nome }}" readonly></td>
        <td width="25%">
            <table>
                <tr>
                    <th>Data do carregamento</th>
                    <td>
                        <input type="text"
                               class="form-control"
                               value="{{ $ordemFrete->data_carregamento->format('d/m/Y') }}"
                               readonly>
                    </td>
                </tr>
            </table>
        </td>
        <td width="25%">
            <table>
                <tr>
                    <th>Previsão de descarga</th>
                    <td>
                        <input type="text"
                               class="form-control"
                               value="{{ $ordemFrete->previsao_descarga->format('d/m/Y') }}"
                               readonly>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th scope="row">Cidade de origem</th>
        <td>
            <input type="text" class="form-control" value="{{ $ordemFrete->cidade_origem }}" readonly>
        </td>
        <th scope="row">Cidade de destino</th>
        <td>
            <input type="text" class="form-control" value="{{ $ordemFrete->cidade_destino }}" readonly>
        </td>
    </tr>
    <tr>
        <th scope="row">Valor do frete</th>
        <td>
            <input type="text"
                   class="form-control"
                   value="{{ number_format($ordemFrete->valor_frete, 2, ',', '.') }}"
                   readonly>
        </td>
        <th scope="row">Peso</th>
        <td>
            <input type="text"
                   class="form-control"
                   value="{{ number_format($ordemFrete->peso, 2, ',', '.') }} {{ $ordemFrete->measure->name }}"
                   readonly>
        </td>
    </tr>
    <tr>
        <th scope="row">Adiantamento</th>
        <td>
            <input type="text"
                   class="form-control"
                   value="{{ number_format($ordemFrete->valorAdiantamento, 2, ',', '.') }} ({{ number_format($ordemFrete->adiantamento) }}%)"
                   readonly>
        </td>
        <th scope="row">Saldo</th>
        <td>
            <input type="text"
                   class="form-control"
                   value="{{ number_format($ordemFrete->valorSaldo, 2, ',', '.') }} ({{ number_format($ordemFrete->saldo) }}%)"
                   readonly>
        </td>
    </tr>
    </tbody>
</table>

<h3 class="custom-font"><strong>Dados Bancários</strong></h3>

<table>
    <tbody>
    <tr>
        <th>Nome do banco</th>
        <td><input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->nome_banco }}" readonly></td>
        <th>Tipo de conta</th>
        <td><input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->tipo_conta }}" readonly></td>
    </tr>
    <tr>
        <th scope="row">Favorecido</th>
        <td>
            <input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->favorecido }}" readonly>
        </td>
        <th scope="row">CPF/CNPJ</th>
        <td>
            <input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->cpf_cnpj }}" readonly>
        </td>
    </tr>
    <tr>
        <th scope="row">Agência</th>
        <td><input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->agencia }}" readonly></td>
        <th scope="row">Conta</th>
        <td><input type="text" class="form-control" value="{{ $ordemFrete->dadosBancarios->conta }}" readonly></td>
    </tr>
    </tbody>
</table>
