<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $table = 'contractors';

    protected $fillable = [
       'name'
    ];
}
