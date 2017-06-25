<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <tr>
      <td align="center"><strong>Data</strong></td>
      <td align="center"><strong>Contrato</strong></td>
      <td align="center"><strong>Vendedor</strong></td>
      <td align="center"><strong>Comprador</strong></td>
      <td align="center"><strong>Produto</strong></td>
      <td align="center"><strong>Preço</strong></td>
      <td align="center"><strong>Volume</strong></td>
      <td align="center"><strong>NF</strong></td>
      <td align="center"><strong>Prazo</strong></td>
      <td align="center"><strong>Total</strong></td>
      <td align="center"><strong>Embarque</strong></td>
      <td align="center"><strong>Vencimento</strong></td>
      <td align="center"><strong>Comissão</strong></td>
      <td align="center"><strong>Total Comissão</strong></td>
    </tr>
    @foreach($orders as $order)
    <tr>
      <td>{{ $order->sell_date->format('d/m/Y') }}</td>
      <td>{{ $order->reference_code }}</td>
      <td>{{ $order->seller->name }}</td>
      <td>{{ $order->client->name }}</td>
      <td>{{ $order->item->product->name }}</td>
      <td>R$ {{ $order->item->price }}</td>
      <td>{{ $order->item->amount }}</td>
      <td></td>
      <td>{{ $order->paymethod->days }} dias {{ $order->paymethod->name }}</td>
      <td>R$ {{ $order->item->price * $order->item->amount }}</td>
      <td></td>
      <td>{{ $order->item->expiry->format('d/m/Y') }}</td>
      <td>{{ $order->commission_unit === 'fixo' ? 'R$' : '' }}{{ $order->commission_value }}{{ $order->commission_unit === 'porcentagem' ? '%' : '' }}</td>
      <td></td>
    </tr>
    @endforeach

  </body>
</html>
