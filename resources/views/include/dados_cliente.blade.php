<table>
    <tbody>
        <tr>
            <th scope="row">Código</th>
            <td><input type="text" class="form-control" value="{{ $company->codigo }}" readonly></td>
        </tr>
        <tr>
            <th>Razão social</th>
            <td colspan="3"><input type="text" class="form-control" value="{{ $company->name }}" readonly></td>
            <th>Nome fantasia</th>
            <td colspan="3"><input type="text" class="form-control" value="{{ $company->nome_fantasia }}" readonly></td>
        </tr>
        <tr>
            <th scope="row">Endereço</th>
            <td colspan="3">
                <input type="text" class="form-control" value="{{ $company->address->name }}, {{ $company->address->number }} {{ $company->address->complemento != '' ? ' - ' . $company->address->complemento : '' }} - {{ $company->address->bairro }}" readonly>
            </td>
            <th scope="row">Cidade</th>
            <td colspan="3"><input type="text" class="form-control" value="{{ $company->address->city->name }}" readonly></td>
        </tr>
        <tr>
            <th scope="row">Estado</th>
            <td><input type="text" class="form-control" value="{{ $company->address->city->state->name }}" readonly></td>
            <th scope="row">CEP</th>
            <td><input type="text" class="form-control" value="{{ $company->address->cep_formatado }}" readonly></td>
            <th scope="row">Caixa postal</th>
            <td><input type="text" class="form-control" value="{{ $company->caixa_postal }}" readonly></td>
        </tr>
        <tr>
            <th scope="row">CNPJ</th>
            <td><input type="text" class="form-control" value="{{ $company->registry }}" readonly></td>
            <th scope="row">IE</th>
            <td><input type="text" class="form-control" value="{{ $company->ie }}" readonly></td>
            <th scope="row">E-mail</th>
            <td><input type="text" class="form-control" value="{{ $company->email }}" readonly></td>
            <th scope="row">Tipo</th>
            <td><input type="text" class="form-control" value="{{ $company->group_name }}" readonly></td>
        </tr>
        <tr>
            <th scope="row">CPF</th>
            <td><input type="text" class="form-control" value="{{ $company->cpf }}" readonly></td>
            <th scope="row">Produtor rural</th>
            <td><input type="text" class="form-control" value="{{ $company->produtor_rural }}" readonly></td>
            <th scope="row">Nome do contato</th>
            <td><input type="text" class="form-control" value="{{ $company->nome_contato }}" readonly></td>
            <th scope="row">Telefone</th>
            <td><input type="text" class="form-control" value="{{ $company->telefone }}" readonly></td>
        </tr>
        <tr>
            <th scope="row">Observações</th>
            <td colspan="7"><input type="text" class="form-control" value="{{ $company->notes }}" readonly></td>
        </tr>
    </tbody>
</table>