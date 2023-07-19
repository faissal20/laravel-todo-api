<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // fillable cols 
    protected $fillable = [
        'title',
        'description',
        'completed',
        'date'
    ];
}
