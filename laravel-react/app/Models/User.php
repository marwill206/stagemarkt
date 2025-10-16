<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'student_id',
        'company_id',
        'role', // Keep this for backward compatibility
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'Student_ID');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'Company_ID');
    }

    // Helper methods
    public function isStudent()
    {
        // Check both fields for compatibility
        return $this->user_type === 'student' || $this->role === 'student';
    }

    public function isCompany()
    {
        // Check both fields for compatibility
        return $this->user_type === 'company' || $this->role === 'company';
    }

    public function getProfileId()
    {
        if ($this->isStudent()) {
            return $this->student_id;
        } elseif ($this->isCompany()) {
            return $this->company_id;
        }
        return null;
    }

    public function getProfile()
    {
        if ($this->isStudent()) {
            return $this->student;
        } elseif ($this->isCompany()) {
            return $this->company;
        }
        return null;
    }

    public function getUserType()
    {
        // Return user_type if it exists, otherwise fall back to role
        return $this->user_type ?? $this->role;
    }
}
