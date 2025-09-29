<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'Student_ID';
    protected $fillable = [
        'Student_Name',
        'Student_Email',
        'Address',
        'Portfolio_Link', // Added missing fields
        'About_Text',
        'Age',
        'Gender',
        'Foto',
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
