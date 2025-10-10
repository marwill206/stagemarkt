<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipMatch extends Model
{
    use HasFactory;

    // Explicitly tell Laravel which table to use
    protected $table = 'match'; // because your DB table is named "match"
    protected $primaryKey = 'Match_ID';

    protected $fillable = [
        'Student_ID',
        'Company_ID',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'Student_ID');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'Company_ID');
    }
}
