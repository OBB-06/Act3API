<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animales';
    protected $primaryKey = 'id_animal';

    protected $fillable = [
        'nombre',
        'tipo',
        'peso',
        'enfermedad',
        'comentarios',
        'id_persona',
    ];

    /**
     * Un animal pertenece a un propietario
     */
    public function propietario()
    {
        return $this->belongsTo(Propietario::class, 'id_persona', 'id_persona');
    }
}
