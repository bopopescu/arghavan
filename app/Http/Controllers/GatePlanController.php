<?php

namespace App\Http\Controllers;

use App\GatePlan;
use Illuminate\Http\Request;
use App\Http\Requests\GatePlanRequest;


class GatePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $gate_plans = GatePlan::paginate(Controller::C_PAGINATE_SIZE);
            return $gate_plans;
        }

        return view('gate_plans.index');
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
    public function store(GatePlanRequest $request)
    {
        if ($request->ajax())
        {
            // Check for duplicate
            $newGatePlan = \App\GatePlan::createIfNotExists($request);

            return [
                'status' => is_null($newGatePlan) ? 1 : 0,
                'gatePlan' => $newGatePlan
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GatePlan  $gatePlan
     * @return \Illuminate\Http\Response
     */
    public function show(GatePlan $gatePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GatePlan  $gatePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(GatePlan $gatePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GatePlan  $gatePlan
     * @return \Illuminate\Http\Response
     */
    public function update(GatePlanRequest $request, GatePlan $gatePlan)
    {
        if ($request->ajax())
        {
            $gatePlan->update([ 'name' => $request->name ]);

            return [
                'status' => 0,
                'gatePlan' => $gatePlan
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GatePlan  $gatePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, GatePlan $gatePlan)
    {
        if ($request->ajax())
        {
            $gatePlan->delete();

            return [
                'status' => 0
            ];
        }
    }
}
