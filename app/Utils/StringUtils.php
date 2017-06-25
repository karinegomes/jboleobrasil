<?php

namespace App\Utils;

use Carbon\Carbon;

trait StringUtils {

    public function formatDate($date) {

        return date('d/m/Y', strtotime($date));

    }

    public function formatDateTime($datetime) {

        return date('d/m/Y H:i', strtotime($datetime));

    }

    public function formatTime($time) {

        return date('H:i', strtotime($time));

    }

    public function formatCurrency($brazilianCurrency) {

        $value = str_replace('.', '', $brazilianCurrency);
        $value = str_replace(',', '.', $value);

        return floatval($value);

    }

    public static function firstDayMonth() {

        $date = new Carbon('first day of this month');

        return date_format($date, 'd/m/Y');

    }

    public static function lastDayMonth() {

        $date = new Carbon('last day of this month');

        return date_format($date, 'd/m/Y');

    }

    public static function setNullWhenEmpty($value) {

        if($value == '') return null;

        return $value;

    }

    public static function setNullWhenEmptyArray($array) {

        foreach($array as $key => $value) {
            if($value == '')
                $array[$key] = null;
        }

        return $array;

    }

    public static function gerarCodigoCliente($id) {

        $stringId = strval($id);
        $count = strlen($stringId);
        $remainingChars = 4 - $count;

        if($remainingChars > 0) {
            for($i = 0; $i < $remainingChars; $i++) {
                $stringId = '0' . $stringId;
            }
        }

        return $stringId;

    }

    public static function mask($mask, $str) {

        $str = str_replace(" ", "", $str);

        for($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;

    }

    // Dado um número, retornar no formato 1.123,5 (remove zeros no final)
    public static function formatarNumeroBrasileiro($valor)
    {
        $valor = number_format($valor, 2, ',', '.');

        $explode = explode(',', $valor);
        $explode[1] = str_replace('0', '', $explode[1]);
        $explode = implode(',', $explode);

        return rtrim($explode, ',');
    }

}