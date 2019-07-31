<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{
	 /**
     * @var array
     */
    protected $guarded = [
        'id'
    ];
     /**
     * @return Get user
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }


}
