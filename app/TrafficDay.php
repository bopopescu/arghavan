<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrafficDay extends Model
{
     use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at'
    ];
}
