<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberEmail extends Model
{
    protected $table = 'member_email';

    protected $fillable = [
        'member_id',
        'email',
        'is_primary'
    ];
}
