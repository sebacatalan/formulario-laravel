<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuestas';
    protected $fillable = [
        'hora',
        'fecha',
        'nacionalidad',
        'motivo_visita',
        'descubrimiento',
        'viaje',
        'transporte',
        'comuna'
    ];
}