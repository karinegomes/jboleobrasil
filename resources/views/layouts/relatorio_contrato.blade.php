<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

        body {
            font-family: Cambria, monospace;
            margin: 10px;
            font-size: 12px;
        }
        table {
            table-layout: fixed;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        table {
            border-collapse: collapse;
        }

        table thead {
            font-weight: bold;
        }

        td, th {
            /*border: 1px solid black;*/
            padding: 3px;
            text-align: center;
        }
    </style>
</head>
<body{{-- style="width:18.6cm"--}}>
    <div class="right">
        {{ $now }}
    </div>
    <div class="center">
        <h1>Relatório de Contratos</h1>
    </div>

    <div>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Data</th>
                    <th>Vendedor</th>
                    <th>Comprador</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Embarque</th>
                    <th>Saldo</th>
                    <th>Valor</th>
                    <th>Observação</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $contrato)
                    <tr>
                        <td>{{ $contrato->reference_code }}</td>
                        <td>{{ $contrato->sell_date }}</td>
                        <td>{{ $contrato->vendedor }}</td>
                        <td>{{ $contrato->comprador }}</td>
                        <td>{{ $contrato->produto }}</td>
                        <td>{{ $contrato->quantidade }}</td>
                        <td>{{ $contrato->quantidade_embarcada }}</td>
                        <td>{{ $contrato->saldo }}</td>
                        <td>{{ $contrato->preco }}</td>
                        <td>{{ $contrato->observacao }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>