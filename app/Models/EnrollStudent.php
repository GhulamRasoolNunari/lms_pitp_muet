<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'father_name',
        'gender',
        'cnic_number',
        'contact_number',
        'date_of_birth',
        'profile_picture',
        'intermediate_marksheet',
        'domicile_form_c',
        'domicile_district',
        'university_name',
    ];
//     public function user()
// {
//     return $this->belongsTo(User::class, 'cnic_number', 'cnic_number');
// }
    public function registered_student()
{
    return $this->belongsTo(StudentRegister::class, 'cnic_number', 'cnic_number');
}
    public function student() {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function enroll_student()
    {
        return $this->hasMany(EnrollStudentDetail::class, 'student_id','student_id');
    }
    public function enroll()
    {
        return $this->hasOne(EnrollStudentDetail::class, 'student_id','student_id');
    }
}
