<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    protected $table = 'propietarios';
    protected $primaryKey = 'id_persona';

    protected $fillable = [
        'nombre',
        'apellido',
    ];

    /**
     * Un propietario puede tener muchos animales
     */
    public function animales()
    {
        return $this->hasMany(Animal::class, 'id_persona', 'id_persona');
    }
}
