<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSkill extends Model
{
    use HasFactory;

    protected $table = 'studentskill'; // 👈 force singular table
    protected $primaryKey = 'studentskill_id';

    protected $fillable = [
        'student_id',
        'skill_id',
        'skill_level',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'Student_ID'); // Fixed reference
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }
}
