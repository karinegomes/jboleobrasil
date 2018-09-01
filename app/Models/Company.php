<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    public $entityType = 'company';
    public $showRoute = 'company.show';

    protected $guarded = ['id'];

    protected $appends = [
        'group_name',
        'state_name',
        'last_note',
        'main_phone',
        'proximo_compromisso',
        'proximo_compromisso_formatado',
        'pintar_amarelo',
    ];

    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function interactions()
    {
        return $this->hasMany('App\Models\Interaction');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'entity');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function sells()
    {
        return $this->hasMany('App\Models\Order', 'seller_id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Models\Order', 'client_id');
    }

    public function baixas()
    {
        return $this->hasMany('App\Models\Baixa');
    }

    public function getGroupNameAttribute()
    {
        return $this->group->name;
    }

    public function getStateNameAttribute()
    {
        $city = $this->address->city;

        if ($city) {
            $state = $city->state->abbreviation;

            return "{$city->name}/{$state}";
        }

        return '';
    }

    public function getLastNoteAttribute()
    {
        $last = $this->interactions()->orderBy('created_at', 'desc')->first();

        if ($last) {
            return $last->created_at;
        } else {
            return null;
        }
    }

    public function getMainPhoneAttribute()
    {
        $main = $this->clients()->where('main', true)->first();

        if ($main) {
            return "({$main->ddd}) {$main->number}";
        } else {
            return null;
        }
    }

    public function getProximoCompromissoAttribute()
    {
        $agora = Carbon::now()->format('Y-m-d H:i:s');

        $compromisso = $this->appointments()->where(function ($query) use ($agora) {
            $query
                ->where(DB::raw('concat(date, \' \', time)'), '>=', $agora)
                ->orWhere(function ($query2) use ($agora) {
                    $query2
                        ->where(DB::raw('concat(date, \' \', time)'), '<=', $agora)
                        ->whereNull('viewed_at')
                        ->whereNotExists(function ($query3) {
                            $query3
                                ->select('id')
                                ->from('appointments as a2')
                                ->where(DB::raw('concat(a2.date, \' \', a2.time)'), '>', DB::raw('concat(appointments.date, \' \', appointments.time)'))
                                ->whereRaw('a2.company_id = appointments.company_id');
                        });
                });
        })->orderBy('date', 'desc')->first();

        // Query
        /*
         SELECT *
            FROM appointments
             WHERE (concat( date, ' ', time ) >= '2017-06-25 14:32:00'
            OR (concat( date, ' ', time ) <= '2017-06-25 14:32:00'
            AND viewed_at IS NULL ))
            AND company_id = 48
              order by date desc
            limit 1
         */

        return $compromisso;
    }

    public function getProximoCompromissoFormatadoAttribute()
    {
        if ($this->proximo_compromisso) {
            return $this->proximo_compromisso->date.' '.$this->proximo_compromisso->time;
        }

        return null;
    }

    public function getPintarAmareloAttribute()
    {
        if ($this->proximo_compromisso) {
            $proximoCompromisso = Carbon::createFromFormat('Y-m-d H:i:s', $this->proximo_compromisso->data);
            $agora = Carbon::now();

            if (($proximoCompromisso->lte($agora) || $proximoCompromisso->isToday()) && !$this->proximo_compromisso->viewed_at) {
                return true;
            }
        }

        return false;
    }

    public static function getClientesComissaoPeriodo($periodo)
    {
        $clientes = Company::all();
        $inicio = Carbon::createFromFormat('Y-m', $periodo)->startOfMonth();
        $fim = Carbon::createFromFormat('Y-m', $periodo)->endOfMonth();

        $clientesResultado = $clientes->filter(function ($value) use ($inicio, $fim) {
            $value->min_date = $inicio;
            $value->max_date = $fim;

            $contratosVenda = $value->sells()->whereIn('status', ['ativo', 'encerrado', 'liquidado'])->get();

            $contratosVenda = $contratosVenda->filter(function ($value) use ($inicio, $fim) {
                $embarques = $value->embarques()->whereBetween('data_pagamento', [$inicio, $fim])->get()
                    ->filter(function ($value) {
                        return $value->comissao_vendedor > 0;
                    });

                return $embarques->count() > 0;
            });

            if ($contratosVenda && $contratosVenda->count() > 0) {
                return true;
            }

            $contratosCompra = $value->purchases()->whereIn('status', ['ativo', 'encerrado', 'liquidado'])->get();

            $contratosCompra = $contratosCompra->filter(function ($value) use ($inicio, $fim) {
                $embarques = $value->embarques()->whereBetween('data_pagamento', [$inicio, $fim])->get()
                    ->filter(function ($value) {
                        return $value->comissao_comprador > 0;
                    });

                return $embarques->count() > 0;
            });

            if ($contratosCompra && $contratosCompra->count() > 0) {
                return true;
            }

            return false;
        });

        return $clientesResultado;
    }
}
