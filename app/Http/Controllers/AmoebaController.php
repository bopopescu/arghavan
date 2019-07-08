<?php

namespace App\Http\Controllers;

use App\Amoeba;
use App\Http\Resources\AmoebaCollection;
use App\Http\Resources\ListDataCollection;
use Illuminate\Http\Request;

class AmoebaController extends Controller
{
    public function __construct ()
    {
    }
    /**
     * List Gate device with card data
     *
     * @param      <type>            $amoeba_ip  The amoeba ip
     *
     * @return     AmoebaCollection  ( description_of_the_return_value )
     */
    public function listAllowTraffic($amoeba_ip)
    {
        $ip = $amoeba_ip;
        $fun = [
            'gatedevices' => function($q) {
                    $q->select([
                        'id',
                        'name',
                        'ip'
                    ]);
                },

                'gatedevices.cards' => function($q) {
                    $q->select([
                        'cards.id',
                        'cards.cdn',
                    ]);
                },
        ];

        $result = Amoeba::where('ip', $ip)
                                ->whereHas('gatedevices', function($query){
                                    $query->whereHas('cards');
                                })
                                ->with($fun)
                                ->select('id', 'name')
                                ->get();

        return new AmoebaCollection($result);
    }

    /**
     * Load valid Person
     *
     * @param      <type>              $amoeba_ip  The amoeba ip
     *
     * @return     ListDataCollection  ( description_of_the_return_value )
     */
    public function listDataUser($amoeba_ip)
    {
        $ip = $amoeba_ip;
        $fun = [
            'gatedevices' => function($q) {
                    $q->select([
                        'id',
                        'name',
                        'ip'
                    ]);
                },

                'gatedevices.cards' => function($q) {
                    $q->select([
                        'cards.id',
                        'cards.cdn',
                    ]);
                },

                'gatedevices.cards.users' => function($q) {
                    $q->select([
                        'users.id',
                        'users.code',
                        'users.people_id'
                    ]);
                },

                'gatedevices.cards.users.people' => function($q) {
                    $q->select([
                        'people.id',
                        'people.name',
                        'people.lastname'
                    ]);
                },
        ];
        $result = Amoeba::where('ip', $ip)
                                ->whereHas('gatedevices', function($query){
                                    $query->whereHas('cards', function($query){
                                        $query->whereHas('users',function($query){
                                            $query->whereHas('people');
                                        } );
                                    });
                                })
                                ->with($fun)
                                ->select('id', 'name')
                                ->get();

        return new ListDataCollection($result);
    }
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
     * @param  \App\Amoeba  $amoeba
     * @return \Illuminate\Http\Response
     */
    public function show(Amoeba $amoeba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Amoeba  $amoeba
     * @return \Illuminate\Http\Response
     */
    public function edit(Amoeba $amoeba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Amoeba  $amoeba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amoeba $amoeba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Amoeba  $amoeba
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amoeba $amoeba)
    {
        //
    }
}
