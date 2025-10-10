<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'student_id',
        'company_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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
        return $this->user_type === 'student';
    }

    public function isCompany()
    {
        return $this->user_type === 'company';
    }

    public function getProfileId()
    {
        return $this->isStudent() ? $this->student_id : $this->company_id;
    }

    public function getProfile()
    {
        return $this->isStudent() ? $this->student : $this->company;
    }
}
