<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audiencias extends Model
{
    protected $table = 'audiencias';

    protected $fillable = [
        'id_processo',
        'data_audiencia',
        'tipo_audiencia',
        'local_audiencia',
        'status_audiencia',
        'obs_audiencia',
        'link_audiencia'
    ];
}
