<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function phases()
    {
        return $this->belongsTo(Phase::class);
    }
}
