<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $table = 'text';      // Singular table
    protected $primaryKey = 'Text_ID';

    protected $fillable = [
        'Text_Name',
        'text',
    ];
}
