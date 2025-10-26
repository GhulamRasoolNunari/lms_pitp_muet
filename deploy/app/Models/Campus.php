<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    //
    protected $fillable = ['title', 'description'];

    public function courseDesignWiseCampus()
    {
        return $this->hasMany(CourseDetail::class, 'campus_id');
    }
    // function phase ()
    // {
    //     return $this->belongsTo(Phase::class, 'phase_id');
    // }
    // function campus()
    // {
    //     return $this->hasOne(Batch::class,'campus_id','id');
    // }
}
