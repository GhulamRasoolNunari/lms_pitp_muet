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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'password',
        'user_type',
        'is_active',
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
            'is_active' => 'boolean',

        ];
    }

    public function student_detail()
    {
        return $this->hasOne(EnrollStudent::class, 'student_id');
    }
    public function enroll_detail()
    {
        return $this->hasOne(EnrollStudentDetail::class, 'student_id');
    }

    // public function register_info()
    // {
    //     return $this->hasOne(StudentRegister::class, 'cnic_number', 'cnic_number');
    // }

    public function hasRole($role)
    {
        return $this->user_type === $role;
    }

    public function std_details()
    {
        return $this->hasMany(EnrollStudentDetail::class, 'student_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }
}
