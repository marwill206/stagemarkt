<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skill'; // 👈 force singular
    protected $primaryKey = 'skill_id';

    protected $fillable = [
        'skill_name',
    ];

    public function studentSkills()
    {
        return $this->hasMany(StudentSkill::class, 'skill_id', 'skill_id');
    }
}
