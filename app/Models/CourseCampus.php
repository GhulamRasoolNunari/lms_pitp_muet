<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCampus extends Model
{
    public $fillable=['course_id','campus_id'];
    /** @use HasFactory<\Database\Factories\CourseCampusFactory> */
    use HasFactory;

    public function campus()
    {
        return $this->belongsTo(Batch::class, 'campus_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
