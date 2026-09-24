<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $table = 'processos';

    protected $fillable = [
        'id_advg',
        'id_cliente',
        'num_processo',
        'tipo_processo',
        'desc_processo',
        'data_abertura_processo',
        'vara_processo',
        'status_processo',
        'comarca',
        'tribunal_processo',
    ];
}
