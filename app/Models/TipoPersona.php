<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $table = 'tipo_persona';

    protected $fillable = ['nombre_tipo'];

    public function users()
    {
        return $this->hasMany(User::class, 'tipo_persona_id');
    }
}
