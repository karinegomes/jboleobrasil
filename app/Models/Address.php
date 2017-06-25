<?php

namespace App\Models;

use App\Utils\StringUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Address extends Model {
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = ['cep_formatado'];

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

    public function company() {
        return $this->hasOne('App\Models\Company');
    }

    public function getCepFormatadoAttribute() {
        return StringUtils::mask('#####-###', $this->zip_code);
    }

    public static function buscarCEP($cep) {

        $token = Config::get('constants.CEP_TOKEN');
        $url = 'http://www.cepaberto.com/api/v2/ceps.json?cep=' . $cep;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . $token . '"'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        return $output;

    }
}
