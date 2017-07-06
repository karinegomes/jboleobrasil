<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['sell_date'];

    public function client()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function freight()
    {
        return $this->belongsTo('App\Models\Freight');
    }

    public function paymethods()
    {
        return $this->hasMany('App\Models\Paymethod');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function detail()
    {
        return $this->belongsTo('App\Models\Detail');
    }

    public function taxes()
    {
        return $this->hasMany('App\Models\Tax');
    }

    public function comissoes()
    {
        return $this->hasMany('App\Models\Comissao', 'contrato_id');
    }

    public function embarques()
    {
        return $this->hasMany('App\Models\Embarque', 'contrato_id');
    }

    public function comissaoVendedor()
    {
        return $this->comissoes()->where('tipo', 'vendedor')->first();
    }

    public function comissaoComprador()
    {
        return $this->comissoes()->where('tipo', 'comprador')->first();
    }

    public function maxCondicaoPagamento()
    {
        $ultimaCondPag = $this->paymethods->last();

        return $ultimaCondPag->days;
    }

    public static function getReferenceCode()
    {
        if (Order::count() > 0) {
            $ultimoContrato = Order::all()->last();
            $referenceCode = $ultimoContrato->reference_code;
            $temp = explode('/', $referenceCode);
            $codigo = $temp[0];
            $countOrder = $codigo + 1;
        }
        else {
            $countOrder = Order::count() + 1;
        }

        return str_pad($countOrder, 4, '0', STR_PAD_LEFT) . '/' . date('y');
    }

    public static function findByReference($code)
    {
        return static::withTrashed()->where('reference_code', $code)->first();
    }

    public function setSellDateAttribute($value)
    {
        $this->attributes['sell_date'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function finalize()
    {
        $this->completed = 1;

        return $this->save();
    }

    public function getValorContrato()
    {
        return $this->item->amount * $this->item->price;
    }

    public function valorTotalComissao()
    {
        $comissaoVendedor = $this->comissaoVendedor();
        $comissaoComprador = $this->comissaoComprador();
        $valorContrato = $this->getValorContrato();
        $totalComissao = 0;

        if($comissaoVendedor) {
            $comissaoVendedorValor = $comissaoVendedor->valor;

            if($comissaoVendedor->unidade == 'fixo') {
                $totalComissao = $totalComissao + $comissaoVendedorValor;
            }
            else {
                $comissaoVendedorValor = ($comissaoVendedorValor/100) * $valorContrato;
                $totalComissao = $totalComissao + $comissaoVendedorValor;
            }
        }

        if($comissaoComprador) {
            $comissaoCompradorValor = $comissaoComprador->valor;

            if($comissaoComprador->unidade == 'fixo') {
                $totalComissao = $totalComissao + $comissaoCompradorValor;
            }
            else {
                $comissaoCompradorValor = ($comissaoCompradorValor/100) * $valorContrato;
                $totalComissao = $totalComissao + $comissaoCompradorValor;
            }
        }

        return $totalComissao;
    }

    public function quantidadeEmbarques()
    {
        return $this->embarques()->count(['id']);
    }

    public function saldoAtual()
    {
        $embarque = $this->embarques->last();

        if($embarque) {
            return $embarque->saldo;
        }

        return $this->item->amount;
    }

    /**
     * Retorna a linha formatada para o contrato em PDF.
     * @return string
     */
    public function condicoesPagamentoFormatado()
    {
        $days = $this->paymethods()->get(['days'])->pluck(['days'])->toArray();
        $complemento = $this->paymethods->last()->name;
        $dias = ' dia ';

        if (array_sum($days) > 1) {
            $dias = ' dias ';
        }

        return implode(', ', $days) . $dias . $complemento;
    }

    public static function boot()
    {
        parent::boot();

        /*Order::creating(function($order) {
            foreach ($order->attributes as $key => $value) {
                $order->{$key} = empty($value) ? null : $value;
            }
        });*/

        /*Order::updating(function($product) {
            foreach ($product->attributes as $key => $value) {
                $product->{$key} = empty($value) ? null : $value;
            }
        });*/
    }
}
