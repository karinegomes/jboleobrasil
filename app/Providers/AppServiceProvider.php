<?php

namespace App\Providers;

use App\Models\Baixa;
use App\Models\Product;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('view')->composer('layouts.app', function ($view) {
            $user = Auth::user();

            $appointments = $user->appointments()->whereDate('date', '=', Carbon::today()->toDateString())
                ->with('company', 'interaction', 'status')->get();

            $view->with(compact('appointments'));
        });

        app('view')->composer('pos_venda.index', function ($view) {
            $intervalosPagamentos = Baixa::intervalos();

            $view->with(compact('intervalosPagamentos'));
        });

        Validator::extend('cnpj', function ($attribute, $value, $parameters, $validator) {
            $cnpj = preg_replace('/[^0-9]/', '', (string)$value);
            // Valida tamanho
            if (strlen($cnpj) != 14) {
                return false;
            }

            // Valida primeiro dígito verificador
            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) {
                return false;
            }

            // Valida segundo dígito verificador
            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
        });

        Validator::extend('cpf', 'App\Validator@cpf');
        Validator::extend('cnpj', 'App\Validator@cnpj');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
