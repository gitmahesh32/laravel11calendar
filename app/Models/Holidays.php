<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'date_of_holiday'
    ];
}
