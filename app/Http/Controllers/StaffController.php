<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
    public function staffChart()
    {
        $labels = [];
        $series = [];
        $group_id = \App\People::$GROUP_STAFFS;
        $res_all = \App\User::where('group_id', $group_id)
                            ->whereHas('people')
                            ->join('staff', 'staff.user_id', 'users.id')
                            ->count();
       $labels[] = "کل";
       $series[] = $res_all;

        $res_has_card = \App\User::where('group_id', $group_id)
                                ->whereHas('people')
                                ->whereHas('cards')
                                ->join('staff', 'staff.user_id', 'users.id')
                                ->count();
        $labels[] = "دارای کارت";
        $series[] = $res_has_card;

       $res_Dont_have_card = \App\User::where('group_id', $group_id)
                                        ->whereHas('people')
                                        ->whereDoesntHave('cards')
                                        ->join('staff', 'staff.user_id', 'users.id')
                                        ->count();
        $labels[] = "بدون کارت";
        $series[] = $res_Dont_have_card;

        $output = [
            'labels' => $labels,
            'series' => $series
        ];
        return $output;
    }

}
