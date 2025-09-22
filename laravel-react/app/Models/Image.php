<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';       // singular table
    protected $primaryKey = 'img_id';

    protected $fillable = [
        'img_name',
        'img_url',
    ];
}
