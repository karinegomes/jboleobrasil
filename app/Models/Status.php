<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    protected $table = 'status';

    const NAO_REALIZADO = 'NAO_REALIZADO';
    const PENDENTE = 'PENDENTE';
    const REALIZADO = 'REALIZADO';

}
