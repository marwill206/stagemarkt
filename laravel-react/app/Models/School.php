<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'School'; 
    protected $primaryKey = 'School_ID'; 

    protected $fillable = [
        'School_Name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'School_ID', 'School_ID');
    }
}
