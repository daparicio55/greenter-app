<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'razon_social',
        'ruc',
        'direccion',
        'logo_path',
        'sol_user',
        'sol_pass',
        'cert_path',
        'client_id',
        'client_secret',
        'produccion',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
