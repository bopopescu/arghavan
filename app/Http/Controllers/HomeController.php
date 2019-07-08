<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileCollection;
use User;

class HomeController extends Controller
{
    public const C_SESSION_LOCK = 'is_locked';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.home.home');
    }
    /**
     * Show the application car dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCar()
    {
        return view('dashboard.car.car');
    }

    /**
     * Edit profile
     * @return [type] [description]
     */
    public function editProfile(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\User::join('people','people.id', '=', 'users.people_id')
                                ->join('groups', 'groups.id', 'users.group_id')
                                ->join('cities','cities.id', 'people.city_id')
                                ->join('provinces', 'provinces.id', 'cities.province_id')
                                ->join('melliats', 'melliats.id', 'people.melliat_id')
                                ->join('genders', 'genders.id', 'people.gender_id')
                                ->select([
                                    'users.id as user_id',
                                    'users.code as user_code',
                                    'users.state as user_state',
                                    'users.email as user_email',
                                    'people.name as people_name',
                                    'people.lastname as people_lastname',
                                    'people.picture as people_picture',
                                    'people.mobile as people_mobile',
                                    'people.address as people_address',
                                    'groups.name as group_name',
                                    'genders.gender as gender',
                                    'melliats.name as melliat',
                                    'cities.name as city',
                                    'provinces.name as province',
                                ])
                                ->where('users.id', \Auth::user()->id)
                                ->get();
            return new ProfileCollection($data);
        }
        return view('auth.edit');
    }

    /**
    * Lock Profile
    */
    public function lockPage(Request $request)
    {
        static::lockUser ();

        if($request->ajax())
        {
            $fun = [
                'people'=>function($q){
                    $q->select([
                        'id',
                        'name',
                        'lastname'
                    ]);
                }
            ];
            $data = \App\User::with($fun)
                              ->where('users.id', \Auth::user()->id)
                              ->select(['id', 'code', 'people_id'])
                              ->get();
            return $data;
        }

        return view('auth.lock');
    }

    /**
     * Lock user
     */
    public static function lockUser ()
    {
        \Session::put (self::C_SESSION_LOCK, true);
    }

    /**
     * unLock user
     */
    public static function unlockUser ()
    {
        \Session::put (self::C_SESSION_LOCK, false);
    }


    /**
     * Is locked user?
     */
    public static function isLocked ()
    {
        $isLocked = \Session::get(self::C_SESSION_LOCK, false);

        return $isLocked;
    }


    public function checkAndUnlockUser (Request $request)
    {
        // $code = request('code');
        // $code = request('code');

        \App\Http\Controllers\HomeController::unlockUser ();
        // dd('ok');
        return [
          'status'  => 200,
          'message' => 'Login Successfully'
        ];
    }


}
