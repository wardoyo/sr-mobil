<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merk extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }

    public function cars()
    {
        return $this->hasMany('\App\Models\Car');
    }
}
