<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GatePlan extends Model
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
    /**
     * Creates if not exists.
     */
    public static function createIfNotExists($request)
    {
        $gatePlan = GatePlan::withTrashed()
                            ->where('name', $request->name)
                            ->first();

        if (is_null($gatePlan))
        {
            $newGatePlan = GatePlan::create([
                    'name' => $request->name,
                    'traffic_day_id' => $request->traffic_day_id,
            ]);

            return $newGatePlan;
        }
        else
        {
            $gatePlan->restore();

            return $gatePlan;
        }

        return null;
    }
}
