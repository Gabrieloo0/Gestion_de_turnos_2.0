<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $table = 'consultorios'; 
    protected $fillable = ['nombre_consultorio','descripcion'];

    public function mount()
    {
        $this->consultorios = Consultorio::all();
    }
}
