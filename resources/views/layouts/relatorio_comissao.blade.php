<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Comissão</title>
    <style media="screen">
        @page { margin: 10px; }

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

        @font-face {
            font-family: Calibri;
            src: url('{{ storage_path('/') }}/fonts/calibrib.ttf') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: "Calibri", monospace;
            margin: 10px;
            font-size: 12px;
        }
        table {
            table-layout: fixed;
        }

        table {
            border-collapse: collapse;
        }

        table thead {
            font-weight: bold;
            background-color: #bfbfbf;
            text-transform: uppercase;
        }

        td, th {
            padding: 3px;
            text-align: center;
        }

        .title h1 {
            font-size: 24px;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>

<div>
    <div class="right">
        {{ $now }}
    </div>

    <table style="width: 100%" class="title">
        <tr>
            <td colspan="3">
                <h1>
                    Relatório de Comissão Contratos a pagar<br>
                    Período de {{ $minDate }} até {{ $maxDate }}
                </h1>
            </td>
            <td style="text-align: right">
                <img src="{{ asset('img/logo.jpg') }}" style="width: 120px">
            </td>
        </tr>
    </table>
</div>

<div>
    <table style="width: 100%">
        <thead>
        <tr>
            <th>Data</th>
            <th>Contrato</th>
            <th width="10%">Vendedor</th>
            <th width="10%">Comprador</th>
            <th width="10%">Produto</th>
            <th>Preço</th>
            <th>% Comissão</th>
            <th>NF Cliente</th>
            <th>Qtde</th>
            <th>Emissão NF</th>
            <th>Vcto NF</th>
            <th>Comissão</th>
        </tr>
        </thead>

        <tbody>
            @foreach($embarques as $embarque)
                <tr>
                    <td>{{ $embarque->contrato->sell_date->format('d/m/Y') }}</td>
                    <td>{{ $embarque->contrato->reference_code }}</td>
                    <td>{{ $embarque->contrato->seller->nome_fantasia }}</td>
                    <td>{{ $embarque->contrato->client->nome_fantasia }}</td>
                    <td>{{ $embarque->contrato->item->product->name }}</td>
                    <td>R$ {{ number_format($embarque->valor_unitario, 2, ',', '.') }}</td>
                    <td>{{ $embarque->getPorcentagemComissaoFormatadoByCliente($idEmpresa) }}</td>
                    <td>{{ $embarque->nota_fiscal }}</td>
                    <td>{{ number_format($embarque->quantidade, 0, ',', '.') }}</td>
                    <td>{{ $embarque->data_embarque ? \Carbon\Carbon::createFromFormat('Y-m-d', $embarque->data_embarque)->format('d/m/Y') : '' }}</td>
                    <td>{{ $embarque->data_pagamento ? \Carbon\Carbon::createFromFormat('Y-m-d', $embarque->data_pagamento)->format('d/m/Y') : '' }}</td>
                    <td>{{ $embarque->getComissaoFormatadoByCliente($idEmpresa) }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>VALOR TOTAL</td>
                <td>{{ $totalComissao }}</td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>