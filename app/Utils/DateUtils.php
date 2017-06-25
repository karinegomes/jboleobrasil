<?php
/**
 * Created by PhpStorm.
 * User: Karine-Note
 * Date: 20/03/2017
 * Time: 14:31
 */

namespace App\Utils;


use DateInterval;
use DatePeriod;
use DateTime;

class DateUtils
{
    public static function intervalo(DateTime $inicio, DateTime $fim)
    {
        $inicio->modify('first day of this month');
        $fim->modify('first day of next month');

        $intervalo = DateInterval::createFromDateString('1 month');
        $periodo   = new DatePeriod($inicio, $intervalo, $fim);
        $meses     = [];

        foreach ($periodo as $dt) {
            $meses[$dt->format('Y-m')] = config('constants.meses.' . $dt->format("n")) . ' - ' . $dt->format("Y");
        }

        return $meses;
    }
}