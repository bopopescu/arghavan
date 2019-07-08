<?php

namespace App\Http\Controllers;

use App\Gatedevice;
use Illuminate\Http\Request;
use App\Http\Requests\GatedeviceRequest;

class GatedeviceController extends Controller
{
     public static $relation = [
        'gatedirect',
        'gategender',
        'zone',
        'gatepass',
        'deviceType'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $gatedevices = Gatedevice::with(self::$relation)
                                ->where('type', '=', 0)
                                ->paginate(Controller::C_PAGINATE_SIZE);
            return $gatedevices;
        }

        return view('gatedevices.index');
    }

    /**
     * Load Logical Device for manual traffic
     */
    public function manualData(Request $request)
    {
        if ($request ->ajax())
        {
            $items = Gatedevice::where('type', '=', '1')
                        ->get();

            return $items;
        }

    }
    /**
     * Load Logical Device for manual traffic
     */
    public function allData(Request $request)
    {
        if ($request ->ajax())
        {
            $items = Gatedevice::select(['id','name'])
                                ->get();
            return $items;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GatedeviceRequest $request)
    {
         if ($request->ajax())
        {
            // Check for duplicate
            $newGatedevice = Gatedevice::createIfNotExists($request);

            $newGatedevice->load(self::$relation)->get();

            return [
                'status'     => is_null($newGatedevice) ? 1 : 0,
                'gatedevice' => $newGatedevice
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gatedevice  $gatedevice
     * @return \Illuminate\Http\Response
     */
    public function show(Gatedevice $gatedevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gatedevice  $gatedevice
     * @return \Illuminate\Http\Response
     */
    public function edit(Gatedevice $gatedevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gatedevice  $gatedevice
     * @return \Illuminate\Http\Response
     */
    public function update(GatedeviceRequest $request, Gatedevice $gatedevice)
    {
        if ($request->ajax())
        {
            $gatedevice->update([
                'name'           => $request->name,
                'ip'             => $request->ip,
                'state'          => $request->state,
                // // 'netState' => $request->netState,
                'timepass'       => $request->timepass,
                'timeserver'     => $request->timeserver,
                'gategender_id'  => $request->gategender_id,
                'gatedirect_id'  => $request->gatedirect_id,
                'gatepass_id'    => $request->gatepass_id,
                'zone_id'        => $request->zone_id,
                'type'           => $request->type,
                'device_type_id'           => $request->device_type_id
            ]);

            $gatedevice->load(self::$relation)->get();

            return [
                'status' => 0,
                'gatedevice'   => $gatedevice
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gatedevice  $gatedevice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Gatedevice $gatedevice)
    {
         if ($request->ajax())
        {
            $gatedevice->delete();

            return [
                'status' => 0
            ];
        }
    }

    /**
     * Return Gate device list
     */
    public function allGatedevices ()
    {
        $list  = Gatedevice::select('id', 'name')
                                ->where('type', '=', '0')
                                ->get();

        return $list;
    }

    /**
     * Counts the number of active gatedevice.
     *
     * @return     integer  ( description_of_the_return_value )
     */
    public function chartCountActiveDevice()
    {
        try {
            $count = \App\Gatedevice::where(function($query){
                                           $query->where('netState', 1);
                                           $query->where('gate',  1);
                                        })
                                    ->count();
        }
        catch (\Exception $e) {
            $count = 0;
        }

        return $count;
    }
    /**
     * Counts the number of active antenna.
     *
     * @return     integer  Number of active antenna.
     */
    public function CountActiveAntenna()
    {
        try {
            $count = \App\Gatedevice::where(function($query){
                                           $query->where('netState', 1);
                                           $query->where('gate',  0);
                                        })
                                    ->count();
        }
        catch (\Exception $e) {
            $count = 0;
        }

        return $count;
    }



}
