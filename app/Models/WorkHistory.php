<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    protected $table = 'work_history';

    protected $fillable = [
        'member_id',
        'contractor_id',
        'title',
        'start_date',
        'end_date'
    ];
}
