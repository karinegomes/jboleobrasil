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
        }
        table {
            table-layout: fixed;
        }

        td {
            /*width: 25%;*/
            overflow: hidden;
            padding: 2px;
        }

        tr.title > th {
            background-color: #5a5a5a;
            color: #fff;
            text-transform: uppercase;
            text-align: left;
            padding: 2px 0 2px 10px;
            font-size: 15px;
        }

        .data {
            font-size: 13px;
        }

        .info-comercial td:first-of-type {
            vertical-align: top;
        }

        .info-comercial td span {
            margin-bottom: 10px;
            display: block;
        }

        .observacoes {
            font-family: "Calibri", sans-serif;
            font-size: 13px;
        }
    </style>
</head>
<body{{-- style="width:18.6cm"--}}>
<table style="width:100%">
    <tbody>
    <tr>
        <td style="width: 15%">
            <img src="{{ asset('img/logo.png') }}" style="display:block; width:100%"/>
        </td>
        <td colspan="3" style="width: 85%">
            <div style="background-color:#02954e;margin:8px 0;color:#fff;text-align:center;padding:3px;">
                <strong style="font-size:24px;">Contrato {{ $order->reference_code }}</strong>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table style="width: 100%">
    <tbody>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">
            <span style="margin:10px 0;font-style:italic;">São Paulo, {{ $date }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding: 10px 0 0 0;">
            <span>{{ $tipo == 'vendedor' ? $order->seller->name : $order->client->name }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding: 0 0 10px 0;">
            <span>A/C Sr. {{ $tipo == 'vendedor' ? $order->seller->nome_contato : $order->client->nome_contato }}</span>
        </td>
    </tr>

    <tr class="title">
        <th colspan="4">
            Vendedor
        </th>
    </tr>

    <tr class="data">
        <td colspan="3">
            <span>{{ $order->seller->name }}</span><br/>
            <span>ENDEREÇO: {{ $order->seller->address->name }}, {{ $order->seller->address->number }} - {{ $order->seller->address->bairro }}</span><br/>
            <span>CIDADE: {{ $order->seller->address->city->name }}</span><br/>
            <span>CNPJ: {{ $order->seller->registry }}</span>
        </td>
        <td colspan="1">
            <span>CEP: {{ $order->seller->address->cep_formatado }}</span><br/>
            <span>UF: {{ $order->seller->address->city->state->abbreviation }}</span><br>
            <span>IE: {{ $order->seller->ie }}</span><br/>
        </td>
    </tr>

    <tr class="title">
        <th colspan="4">
            Comprador
        </th>
    </tr>

    <tr class="data">
        <td colspan="3">
            <span>{{ $order->client->name }}</span><br/>
            <span>ENDEREÇO: {{ $order->client->address->name }}, {{ $order->client->address->number }} - {{ $order->client->address->bairro }}</span><br/>
            <span>CIDADE: {{ $order->client->address->city->name }}</span><br/>
            <span>CNPJ: {{ $order->client->registry }}</span><br/>
            <span>INSCRIÇÃO: {{ $order->client->ie }}</span><br/>
        </td>
        <td colspan="1">
            <span>CEP: {{ $order->client->address->cep_formatado }}</span><br/>
            <span>UF: {{ $order->client->address->city->state->abbreviation }}</span><br>
            <span>IE: {{ $order->client->ie }}</span><br/>
        </td>
    </tr>

    <tr class="title">
        <th colspan="4" style="text-align: center !important">
            Informações Comerciais
        </th>
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>PRODUTO</strong></td>
        <td colspan="3">{{ $order->item->product->name }}</td>
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>ESPECIFICAÇÕES</strong></td>
        <td colspan="3">
            @foreach($order->item->product->specs as $spec)
                <span style="margin-bottom: 2px">{{ $spec->name }} {{ $spec->value }}</span>
            @endforeach
        </td>
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>QUANTIDADE</strong></td>
        <td colspan="3">{{ number_format($order->item->amount, 0, ',', '.') }} {{ $order->item->measure->abbreviation }}</td>
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>EMBALAGEM</strong></td>
        <td colspan="3">{{ $order->item->package->name }}</td>
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>PREÇO</strong></td>
        <td colspan="3">R$ {{ $order->item->linhaPrecoContrato($order) }}</td> {{-- TODO --}}
    </tr>

    <tr class="data info-comercial">
        <td colspan="1"><strong>CONDIÇÕES DE PAGTO</strong></td>
        <td colspan="3">{{ $order->condicoesPagamentoFormatado() }}</td>
    </tr>

    @if($order->freight->address != '')
        <tr class="data info-comercial">
            <td colspan="1"><strong>LOCAL DE ENTREGA</strong></td>
            <td colspan="3">{{ $order->freight->address }}</td>
        </tr>
    @endif

    <tr class="data info-comercial">
        <td colspan="1"><strong>{{ strtoupper($order->detail->type) }}</strong></td>
        <td colspan="3">{{ $order->detail->description }}</td>
    </tr>

    @if($tipo == 'vendedor' && $order->comissaoVendedor())
        <tr class="data info-comercial">
            <td colspan="1"><strong>COMISSÃO</strong></td>
            <td colspan="3">{{ $order->comissaoVendedor()->valor_formatado }}</td>
        </tr>
    @elseif($tipo == 'comprador' && $order->comissaoComprador())
        <tr class="data info-comercial">
            <td colspan="1"><strong>COMISSÃO</strong></td>
            <td colspan="3">{{ $order->comissaoComprador()->valor_formatado }}</td>
        </tr>
    @endif

    {{-- TODO: Comissão --}}

    <tr class="data info-comercial">
        <td><strong>Observações</strong></td>
    </tr>

    <tr>
        <td colspan="4" style="border:1px solid #CCCCCC; padding: 5px 15px;" class="observacoes">
            *** ENVIAR LAUDO DE ANÁLISE ANEXO A NOTA FISCAL.<br>
            QUALQUER DISCREPÂNCIA RETORNAR IMEDIATAMENTE, PELA MESMA VIA
            NO PRAZO DE 24 H. DO RECEBIMENTO DESTE CONTRATO.<br>
            VENDA FOB RESPONSABILIDADE PELO TRANSPORTE E TRÂNSITO DA
            MERCADORIA DO COMPRADOR.<br>
            SERÁ CONSIDERADO COMO NORMAL QUEBRA DE PESO DE ATÉ 0,25% PARA
            MAIS OU PARA MENOS, SEM QUE HAJA DESCONTO OU ACRÉSCIMO NAS
            DUPLICATAS. A QUEBRA DE PESO COM PERCENTUAL ACIMA DE 0,25%
            SOFRERÁ ÁGIO OU DESAGIO NAS DUPLICATAS DAS DIFERENÇAS.<br>
            <br>
            GRATO POR MAIS ESSE NEGÓCIO.<br>
            <br>
            JABER Fone: (11) 2206-0343 E-Mail: jaber@jboleobrasil.com.br

        </td>
    </tr>
    <tr style="text-align:center;text-transform:uppercase;">
        <td colspan="2" style="color:#77923c;padding:5px;">
            <hr style="border:1px solid black;margin-top:30px;">
            <span>Vendedor</span>
        </td>
        <td colspan="2" style="color:#77923c;padding:10px;">
            <hr style="border:1px solid black;margin-top:30px;">
            <span>Comprador</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="font-size: 14px">
            {{--<hr style="margin:10px 0px;border:none;">--}}
            Atenciosamente,<br>
            JBOleoBrasil
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
