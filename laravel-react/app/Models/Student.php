<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'Student_name',
        'Student_Email',
        'Address',
        'age',
        'gender',
        'foto',
        'Profession_ID',
        'School_ID'
    ];

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'Profession_ID', 'Profession_ID');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'School_ID', 'School_ID');
    }

    public function skills()
    {
        return $this->hasMany(StudentSkill::class, 'student_id', 'Student_ID');
    }
}
