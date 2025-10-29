<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];
    // its for course_details only setting it for register-> enroll_students for now
    public function courseDesignWiseBatch()
    {
        return $this->hasMany(CourseDetail::class, 'batch_id');
    }
    // // Campus are batches
    // public function campus()
    // {
    //     return $this->belongsTo(Campus::class);
    // }
    // public function phase()
    // {
    //     return $this->belongsTo(Phase::class);
    // }
}
