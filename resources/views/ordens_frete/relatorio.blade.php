<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">


        @font-face {
            font-family: Cambria;
            src: url('{{ storage_path('/') }}/fonts/Cambria.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: Cambria;
            src: url('{{ storage_path('/') }}/fonts/cambriab.ttf') format('truetype');
            font-weight: bold;
        }

        @font-face {
            font-family: Cambria;
            src: url('{{ storage_path('/') }}/fonts/cambriai.ttf') format('truetype');
            font-style: italic;
        }

        @font-face {
            font-family: Calibri;
            src: url('{{ storage_path('/') }}/fonts/calibri.ttf') format('truetype');
            font-style: normal;
            font-weight: normal;
        }

        body {
            font-family: Cambria, monospace;
            margin: 10px;
        }
        table {
            table-layout: fixed;
        }

        td {
            /*width: 25%;*/
            overflow: hidden;
            padding: 2px;
        }

        p {
            margin: 10px 0;
        }

        tr.title > th {
            background-color: #5a5a5a;
            color: #fff;
            text-transform: uppercase;
            text-align: left;
            padding: 2px 0 2px 10px;
            font-size: 15px;
        }

        .info-comercial td:first-of-type {
            vertical-align: top;
        }

        .info-comercial td span {
            margin-bottom: 10px;
            display: block;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="text-center">
    <h1>ORDEM DE FRETE</h1>
</div>

<p><strong>Motorista:</strong></p>

<table width="100%">
    <tr>
        <td>Nome: {{ $ordemFrete->motorista->nome }}</td>
        <td>CPF: {{ $ordemFrete->motorista->cpf }}</td>
    </tr>
    <tr>
        <td>Telefone: {{ $ordemFrete->motorista->telefone }}</td>
        <td>Celular: {{ $ordemFrete->motorista->celular }}</td>
    </tr>
    <tr>
        <td>Tipo de caminhão: {{ $ordemFrete->motorista->tipoDeCaminhao ? $ordemFrete->motorista->tipoDeCaminhao->nome : '' }}</td>
        <td>Placa: {{ $ordemFrete->motorista->placa }}</td>
    </tr>
    <tr>
        <td colspan="2">
            Endereço:<br>
            {!! nl2br($ordemFrete->motorista->endereco) !!}
        </td>
    </tr>
</table>

<p><strong>Frete:</strong></p>

<table width="100%">
    <tr>
        <td>Data do carregamento: {{ $ordemFrete->data_carregamento ? $ordemFrete->data_carregamento->format('d/m/Y') : '' }}</td>
        <td>Previsão de descarga: {{ $ordemFrete->previsao_descarga ? $ordemFrete->previsao_descarga->format('d/m/Y') : '' }}</td>
    </tr>
    <tr>
        <td>Cidade de origem: {{ $ordemFrete->cidade_origem }}</td>
        <td>Cidade de destino: {{ $ordemFrete->cidade_destino }}</td>
    </tr>
    <tr>
        <td>Valor do frete: {{ $ordemFrete->valor_frete ? 'R$ '.number_format($ordemFrete->valor_frete, 2, ',', '.') : '' }}</td>
        <td>Peso: {{ number_format($ordemFrete->peso, 2, ',', '.') }} {{ $ordemFrete->measure ? $ordemFrete->measure->name : '' }}</td>
    </tr>
    <tr>
        <td>Adiantamento: R$ {{ number_format($ordemFrete->valorAdiantamento, 2, ',', '.') }} ({{ number_format($ordemFrete->adiantamento) }}%)</td>
        <td>Saldo: R$ {{ number_format($ordemFrete->valorSaldo, 2, ',', '.') }} ({{ number_format($ordemFrete->saldo) }}%)</td>
    </tr>
</table>

<p><strong>Dados bancários:</strong></p>

<table width="100%">
    <tr>
        <td>Nome do banco: {{ $ordemFrete->dadosBancarios->nome_banco }}</td>
        <td>Tipo de conta: {{ $ordemFrete->dadosBancarios->tipo_conta }}</td>
    </tr>
    <tr>
        <td>Favorecido: {{ $ordemFrete->dadosBancarios->favorecido }}</td>
        <td>CPF/CNPJ: {{ $ordemFrete->dadosBancarios->cpf_cnpj }}</td>
    </tr>
    <tr>
        <td>Agência: {{ $ordemFrete->dadosBancarios->agencia }}</td>
        <td>Conta: {{ $ordemFrete->dadosBancarios->conta }}</td>
    </tr>
</table>
</body>
</html>
