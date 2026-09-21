<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $table = 'processos';

    protected $fillable = [
        'numero',
        'cliente',
        'assunto',
        'tipo',
        'status',
        'prazo',
    ];
}
