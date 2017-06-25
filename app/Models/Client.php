<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model {
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['company_name'];

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }

    public function carrier() {
        return $this->belongsTo('App\Models\Carrier');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getCompanyNameAttribute() {
        return $this->company->name;
    }

    public function telephones() {
        return $this->hasMany('App\Models\Telephone');
    }

}
