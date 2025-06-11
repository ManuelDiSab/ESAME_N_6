<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriePreferite extends Model
{
    use HasFactory;

    protected $table = 'Serie-preferite';
    protected $primaryKey = 'idSeriePreferita';


    protected $fillable = [
        'idUser',
        'idSerie'
    ];
}
