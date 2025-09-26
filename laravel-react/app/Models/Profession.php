<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $table = 'Professions'; 
    protected $primaryKey = 'Profession_ID'; 

    protected $fillable = [
        'Profession_Name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'Profession_ID', 'Profession_ID');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'Profession_ID', 'Profession_ID');
    }
}
