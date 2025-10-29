<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'father_name',
        'gender',
        'cnic_number',
        'email',
        'contact_number',
        'date_of_birth',
        'profile_picture',
        'intermediate_marksheet',
        'domicile_form_c',
        'domicile_category',
        'domicile_district',
        'is_enrolled',
        'enrolled_status',
        'most_recent_institution',
        'highest_qualification',
        'preferred_study_center',
        'preferred_time_slot',
        'course_choice_1',
        'course_choice_2',
        'course_choice_3',
        'course_choice_4',
        'have_disability',
        'monthly_household_income',
        'participated_previously',
        'course_if_participated',
        'phase_if_participated',
        'center_if_participated',
        'from_source',
        'info_confirm',
    ];
    public function enrollments()
    {
        return $this->hasOne(EnrollStudent::class, 'cnic_number', 'cnic_number');
    }
}
