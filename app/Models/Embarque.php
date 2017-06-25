<?php

namespace App\Models;

use App\Utils\DateUtils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Embarque extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['saldo', 'comissao_vendedor', 'comissao_vendedor_formatado', 'comissao_comprador',
        'comissao_comprador_formatado', 'valor_unitario'];

    public function contrato()
    {
        return $this->belongsTo('App\Models\Order', 'contrato_id');
    }

    public function descontos()
    {
        return $this->hasMany('App\Models\Desconto');
    }

    public function baixa()
    {
        return $this->hasOne('App\Models\Baixa');
    }

    public function scopeLast($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    public function dataEmbarqueFormatado()
    {
        if($this->data_embarque)
            return Carbon::createFromFormat('Y-m-d', $this->data_embarque)->format('d/m/Y');

        return '';
    }

    public function dataPagamentoFormatado()
    {
        if($this->data_pagamento)
            return Carbon::createFromFormat('Y-m-d', $this->data_pagamento)->format('d/m/Y');

        return '';
    }

    public function getSaldoAttribute()
    {
        $quantidade = $this->contrato->item->amount;
        $embarquesAnteriores = $this->contrato->embarques()->where('created_at', '<', $this->created_at)->get();

        if($embarquesAnteriores->count() > 0) {
            foreach ($embarquesAnteriores as $embarqueAnterior) {
                $saldo = $embarqueAnterior->saldo - $this->quantidade;
            }
        }
        else {
            $saldo = $quantidade - $this->quantidade;
        }

        return $saldo;
    }

    public function getComissaoVendedorAttribute()
    {
        $comissaoVendedor = $this->contrato->comissaoVendedor();

        if($comissaoVendedor) {
            if($comissaoVendedor->unidade == 'fixo') {
                return $comissaoVendedor->valor;
            }

            $quantidade = $this->quantidade;
            $preco = $this->contrato->item->price;

            foreach ($this->descontos as $desconto) {
                if($desconto->tipo == 'peso') {
                    $quantidade = $quantidade - $desconto->valor;
                }
                else {
                    $preco = $desconto->valor;
                }
            }

            $valor = ($quantidade * $preco);

            return $valor * ($comissaoVendedor->valor/100);
        }

        return null;
    }

    public function getComissaoVendedorFormatadoAttribute()
    {
        if($this->comissao_vendedor) {
            return 'R$ ' . number_format($this->comissao_vendedor, 2, ',', '.');
        }

        return null;
    }

    public function getComissaoCompradorAttribute()
    {
        $comissaoComprador = $this->contrato->comissaoComprador();

        if($comissaoComprador) {
            if($comissaoComprador->unidade == 'fixo') {
                return $comissaoComprador->valor;
            }

            $quantidade = $this->quantidade;
            $preco = $this->contrato->item->price;

            foreach ($this->descontos as $desconto) {
                if($desconto->tipo == 'peso') {
                    $quantidade = $quantidade - $desconto->valor;
                }
                else {
                    $preco = $desconto->valor;
                }
            }

            $valor = ($quantidade * $preco);

            return ($valor) * ($comissaoComprador->valor/100);
        }

        return null;
    }

    public function getComissaoCompradorFormatadoAttribute()
    {
        if($this->comissao_comprador) {
            return 'R$ ' . number_format($this->comissao_comprador, 2, ',', '.');
        }

        return null;
    }

    public function getValorUnitarioAttribute()
    {
        if($this->descontos->count() > 0) {
            foreach ($this->descontos as $desconto) {
                if($desconto->tipo == 'valor') {
                    return $desconto->valor;
                }
            }
        }

        return $this->contrato->item->price;
    }

    public function getComissaoFormatadoByCliente($id)
    {
        if($this->contrato->seller_id == $id) {
            return $this->comissao_vendedor_formatado;
        }

        return $this->comissao_comprador_formatado;
    }

    public function getComissaoByCliente($id)
    {
        if($this->contrato->seller_id == $id) {
            return $this->comissao_vendedor;
        }

        return $this->comissao_comprador;
    }

    public function getPorcentagemComissaoFormatadoByCliente($id)
    {
        if($this->contrato->seller_id == $id) {
            return $this->contrato->comissaoVendedor()->valor_formatado;
        }

        return $this->contrato->comissaoComprador()->valor_formatado;
    }

    public static function getEmbarquesAtivosByCliente($idEmpresa, $dataMin, $dataMax)
    {
        return Embarque::whereHas('contrato', function($query) use ($idEmpresa) {
            $query->where('client_id', $idEmpresa)
                ->orWhere('seller_id', $idEmpresa)
                ->whereIn('status', ['ativo', 'encerrado']);
        })->whereBetween('data_pagamento', [$dataMin, $dataMax])->get()->filter(function ($embarque) use ($idEmpresa) {
            $eVendedor = $embarque->contrato->seller_id == $idEmpresa;

            if($eVendedor) {
                if($embarque->comissao_vendedor > 0) {
                    return true;
                }
            }
            else {
                if($embarque->comissao_comprador > 0) {
                    return true;
                }
            }

            return false;
        })->sortBy('contrato.sell_date');
    }

    public static function getEmbarquesAtivosByClienteArray($idEmpresa, $dataMin, $dataMax)
    {
        $embarques = Embarque::getEmbarquesAtivosByCliente($idEmpresa, $dataMin, $dataMax);
        $result    = [];

        foreach ($embarques as $embarque) {
            $_embarque['contrato']            = $embarque->contrato->reference_code;
            $_embarque['vendedor']            = $embarque->contrato->seller->nome_fantasia;
            $_embarque['comprador']           = $embarque->contrato->client->nome_fantasia;
            $_embarque['produto']             = $embarque->contrato->item->product->name;
            $_embarque['preco']               = 'R$ ' . number_format($embarque->valor_unitario, 2, ',', '.');
            $_embarque['porcentagemComissao'] = $embarque->getPorcentagemComissaoFormatadoByCliente($idEmpresa);
            $_embarque['notaFiscal']          = $embarque->nota_fiscal;
            $_embarque['quantidade']          = number_format($embarque->quantidade, 0, ',', '.');
            $_embarque['emissaoNF']           = $embarque->data_embarque ? Carbon::createFromFormat('Y-m-d', $embarque->data_embarque)->format('d/m/Y') : null;
            $_embarque['vencimentoNF']        = $embarque->data_pagamento ? Carbon::createFromFormat('Y-m-d', $embarque->data_pagamento)->format('d/m/Y') : null;
            $_embarque['comissao']            = $embarque->getComissaoFormatadoByCliente($idEmpresa);
            $_embarque['observacao']          = $embarque->baixa ? $embarque->baixa->observacao : null;
            $_embarque['agroSD']              = $embarque->baixa && $embarque->baixa->agrosd ? 'R$ ' . number_format($embarque->baixa->agrosd, 2, ',', '.') : null;
            $_embarque['silas']               = $embarque->baixa && $embarque->baixa->silas ? 'R$ ' . number_format($embarque->baixa->silas, 2, ',', '.') : null;
            $_embarque['dayane']              = $embarque->baixa && $embarque->baixa->dayane ? 'R$ ' . number_format($embarque->baixa->dayane, 2, ',', '.') : null;
            $_embarque['idCliente']           = $idEmpresa;
            $_embarque['id']                  = $embarque->id;
            $_embarque['status']              = $embarque->status;
            $_embarque['idBaixa']             = $embarque->baixa ? $embarque->baixa->id : null;
            $_embarque['valorPago']           = $embarque->baixa ? 'R$ ' . number_format($embarque->baixa->valor, 2, ',', '.') : null;

            array_push($result, $_embarque);
        }

        return $result;
    }

    public static function getEmbarquesAtivosByClienteJSON($idEmpresa, $dataMin, $dataMax)
    {
        $result = Embarque::getEmbarquesAtivosByClienteArray($idEmpresa, $dataMin, $dataMax);

        return json_encode($result);
    }

    public static function embarquesAtivosFiltro($dataMin, $dataMax, $compradorId = 'todos', $vendedorId = 'todos')
    {
        $embarques = Embarque::whereBetween('data_pagamento', [$dataMin, $dataMax])
            ->whereHas('contrato', function($query) use ($compradorId, $vendedorId) {
                $query->whereIn('status', ['ativo', 'encerrado']);

                if($compradorId != 'todos') {
                    $query->where('client_id', $compradorId);
                }

                if($vendedorId != 'todos') {
                    $query->where('seller_id', $vendedorId);
                }
            })->get()->filter(function($embarque) use ($compradorId, $vendedorId) {
                return ($embarque->comissao_vendedor > 0 || $embarque->comissao_comprador > 0);
            });

        return $embarques;
    }

    public static function intervaloDataPagamentoEmbarquesAtivos($dataMin, $dataMax, $compradorId, $vendedorId)
    {
        $embarques = Embarque::embarquesAtivosFiltro($dataMin, $dataMax, $compradorId, $vendedorId);

        if($embarques->count() == 0) {
            return null;
        }

        $embarques = $embarques->sortBy('data_pagamento');
        $min       = Carbon::createFromFormat('Y-m-d', $embarques->first()->data_pagamento);
        $max       = Carbon::createFromFormat('Y-m-d', $embarques->last()->data_pagamento);
        $intervalo = DateUtils::intervalo($min, $max);
        $intervalos = [];

        foreach ($intervalo as $key => $_intervalo) {
            $temp = [
                'nome' => $_intervalo,
                'periodo' => $key
            ];

            array_push($intervalos, $temp);
        }

        return $intervalos;
    }


    /**
     * Retorna a soma dos valores a pagar do comprador e vendedor
     *
     * @return double
     */
    public function getValorCobranca()
    {
        $comissaoComprador = $this->comissao_comprador ? $this->comissao_comprador : 0;
        $comissaoVendedor  = $this->comissao_vendedor ? $this->comissao_vendedor : 0;

        return $comissaoComprador + $comissaoVendedor;
    }

    public static function getInformacoesByPeriodo($periodo)
    {
        $inicio   = Carbon::createFromFormat('Y-m', $periodo)->startOfMonth();
        $fim      = Carbon::createFromFormat('Y-m', $periodo)->endOfMonth();

        $embarques = Embarque::embarquesAtivosFiltro($inicio, $fim);
        $cobranca = 0;
        $agrosd = 0;
        $silas = 0;
        $dayane = 0;
        $pago = 0;

        foreach ($embarques as $embarque) {
            $cobranca += $embarque->getValorCobranca();

            if($embarque->baixa) {
                $agrosd += $embarque->baixa->agrosd ? $embarque->baixa->agrosd : 0;
                $silas  += $embarque->baixa->silas ? $embarque->baixa->silas : 0;
                $dayane += $embarque->baixa->dayane ? $embarque->baixa->dayane : 0;
                $pago   += $embarque->baixa->valor;
            }
        }

        $data = [
            'cobranca' => number_format($cobranca, 2, ',', '.'),
            'agroSD'   => number_format($agrosd, 2, ',', '.'),
            'silas'    => number_format($silas, 2, ',', '.'),
            'dayane'   => number_format($dayane, 2, ',', '.'),
            'pago'     => number_format($pago, 2, ',', '.')
        ];

        return $data;
    }

    public static function boot()
    {
        static::creating(function (Embarque $embarque) {
            if($embarque->data_embarque)
                $embarque->data_embarque = Carbon::createFromFormat('d/m/Y', $embarque->data_embarque);

            if($embarque->data_pagamento)
                $embarque->data_pagamento = Carbon::createFromFormat('d/m/Y', $embarque->data_pagamento);
        });

        static::deleting(function(Embarque $embarque) {
            $embarque->descontos()->delete();
        });
    }
}