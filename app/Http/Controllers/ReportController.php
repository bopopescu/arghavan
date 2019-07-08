<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TrafficCollection;
use App\Http\Resources\SearchUserCollection;
use App\Http\Resources\SearchEditUserCollection;
use App\Http\Resources\ReportCollection;


use App\User;
use App\Group;
use App\People;
use App\Card;
use App\Gatetraffic;
use App\Gatedirect;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    /**
     * Constrcutor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Search
     */
    public function index(Request $request)
    {
        return view('reports.index');
    }
    /**
     * Get Traffics
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public static function getTraffics (Request $request, $id = null)
    {
        $relation = [
            'user',
            'user.people',
            'gatedevice',
            'gatepass',
            'gatedirect',
            'gatemessage',
        ];


        if((\Auth::user()->level_id) == 1)
        {
            $traffic = \App\Gatetraffic::with($relation);
        }
        elseif ((\Auth::user()->level_id) == 3) {
            $traffic = \App\Gatetraffic::with($relation)
                    ->where('user_id', \Auth::user()->id);
        }

        if (! is_null ($id))
        {
            $traffic->where('id', $id)
                    ->with($relation);
        }

        $traffic->orderBy('gatedate','DESC')
                ->limit(\App\Report::$LIMIT);

        return $traffic->paginate(Controller::C_PAGINATE_SIZE);
    }

    /**
     * Show 50 Last Tarffic
     */
    public function showTraffic(Request $request)
    {
        if ($request->ajax())
        {
            $traffic = static::getTraffics($request, null);

            return $traffic;
       }

        return view('reports.index');
    }

    /**
     * Show 50 Last Tarffic
     */
    public function monitorTraffic(Request $request)
    {
        if ($request->ajax())
        {
            $traffic = static::getTraffics($request, null);

            return $traffic;
       }

        return view('reports.monitor.index');
    }

   /**
    * Show User by Search
    */
    public function showUser(Request $request)
    {
        // return view('searches.index');
        return view('reports.user.index');
    }

    /**
     * Search User Report
     */
    public function searchUser(Request $request)
    {
        $items = User::where(function ($query) use ($request){
                    if (! is_null ($request->code)){
                          $query->where('users.code', '=', $request->code);
                    }

                    $query->where('users.group_id', '=', $request->group_id);
                })
                ->join('people', function($join) use ($request) {
                    $join->on ('people.id', '=', 'users.people_id');

                    if (! is_null ($request->nationalId)){
                        $join->where('people.nationalId', '=', $request->nationalId);
                    }

                    if (! is_null ($request->name)){
                        $join->where('people.name', 'like', '%' . $request->name . '%');
                    }

                    if (! is_null ($request->lastname)){
                        $join->where('people.lastname', 'like', '%' .  $request->lastname . '%');
                    }
                })
                ->join('groups', 'groups.id', '=', 'users.group_id')

                ->leftJoin('cards', 'cards.user_id', '=', 'users.id')
                ->select([
                    'groups.name as group_name',
                    'groups.id as group_id',
                    'users.id as user_id',
                    'users.code as user_code',
                    'users.name as user_name',
                    'people.id as people_id',
                    'people.name as people_name',
                    'people.lastname as people_lastname',
                    'people.nationalId as people_nationalId',
                    'cards.cdn as card_cdn',
                    // 'group_permits.id as group_permit_id',
                    // 'roles.id as role_id',
                    // 'permissions.id as permission_id',
                    // 'gategroups.id as gategroup_id',
                ])

                ->paginate(Controller::C_PAGINATE_SIZE);

            return new SearchUserCollection($items);
    }

     /**
     * Search User Report
     */
    public function searchEditUser(Request $request)
    {
        $items = User::where(function ($query) use ($request){
                    if (! is_null ($request->user['code'])){
                          $query->where('users.code', '=', $request->user['code']);
                    }

                    $query->where('users.group_id', '=', $request->group['id']);
                })
                ->join('people', function($join) use ($request) {
                    $join->on ('people.id', '=', 'users.people_id');

                    if (! is_null ($request->people['nationalId'])){
                        $join->where('people.nationalId', '=', $request->people['nationalId']);
                    }

                    if (! is_null ($request->people['name'])){
                        $join->where('people.name', 'like', '%' . $request->people['name'] . '%');
                    }

                    if (! is_null ($request->people['lastname'])){
                        $join->where('people.lastname', 'like', '%' .  $request->people['lastname'] . '%');
                    }
                })
                ->join('groups', 'groups.id', '=', 'users.group_id')
                ->join('melliats', 'melliats.id', '=', 'people.melliat_id')
                ->join('genders', 'genders.id', '=', 'people.gender_id')
                ->join('cities', 'cities.id', '=', 'people.city_id')
                ->join('provinces', 'provinces.id', '=', 'cities.province_id')
                ->leftJoin('cards', 'cards.user_id', '=', 'users.id')
                ->join('cardtypes', 'cardtypes.id', '=', 'cards.cardtype_id')
                ->leftJoin('staff', 'staff.user_id', '=', 'users.id')
                ->leftJoin('teachers', 'teachers.user_id', '=', 'users.id')
                ->leftJoin('students', 'students.user_id', '=', 'users.id')
                ->leftJoin('contracts', 'contracts.id', '=', 'staff.contract_id')
                ->leftJoin('departments', 'departments.id', '=', 'staff.department_id')
                ->leftJoin('degrees', 'degrees.id', '=', 'students.degree_id')
                ->leftJoin('fields', 'fields.id', '=', 'students.field_id')
                ->leftJoin('parts', 'parts.id', '=', 'students.part_id')
                ->leftJoin('situations', 'situations.id', '=', 'students.situation_id')
                ->leftJoin('universities', 'universities.id', '=', 'fields.university_id')

                ->select([
                    /* User data */
                    'users.id as user_id',
                    'users.code as user_code',
                    'users.name as user_name',
                    'users.email as user_email',
                    'users.state as user_state',
                    /* Group data */
                    'groups.id as group_id',
                    'groups.name as group_name',

                    /* People data */
                    'people.id as people_id',
                    'people.name as people_name',
                    'people.lastname as people_lastname',
                    'people.nationalId as people_nationalId',
                    'people.birthdate as people_birthdate',
                    'people.phone as people_phone',
                    'people.mobile as people_mobile',
                    'people.address as people_address',
                    'people.picture as people_picture',

                    /* Melliat data */
                    'melliats.id as melliat_id',
                    'melliats.name as melliat_name',

                    /* Gender data */
                    'genders.id as gender_id',
                    'genders.gender as gender_gender',

                    /* City data */
                    'cities.id as city_id' ,
                    'cities.name as city_name' ,

                    /* Province data */
                    'provinces.id as province_id',
                    'provinces.name as province_name',

                    /* Card data */
                    'cards.id as card_id',
                    'cards.cdn as card_cdn',
                    'cards.state as card_state',
                    'cards.startDate as card_startDate',
                    'cards.endDate as card_endDate',

                    /* Card Type data */
                    'cardtypes.id as cardtype_id',
                    'cardtypes.name as cardtype_name',

                    /* Staff data */
                    'staff.id as staff_id',

                    /* Contract data */
                    'contracts.id as contract_id',
                    'contracts.name as contract_name',

                    /* Department data */
                    'departments.id as department_id',
                    'departments.name as department_name',

                    /* Teacher data */
                    'teachers.id as teacher_id',
                    'teachers.semat as teacher_semat',

                    /* Student data */
                    'students.id as student_id',
                    'students.year as student_year',
                    'students.term as student_term',
                    'students.native as student_native',
                    'students.suit as student_suit',
                    'situations.id as situation_id',
                    'situations.name as situation_name',
                    'degrees.id as degree_id',
                    'degrees.name as degree_name',
                    'fields.id as field_id',
                    'fields.name as field_name',
                    'universities.id as university_id',
                    'universities.name as university_name',
                    'parts.id as part_id',
                    'parts.name as part_name',
                ])
                ->paginate(Controller::C_PAGINATE_SIZE);
            return new SearchEditUserCollection($items);
    }

    /**
     * Search User By code or group_id or nationalid or name or lastname or serial card or date
     */
     public function searchTraffic(Request $request)
    {
        $dateRange = [
                          $request->startDate,
                          $request->endDate
                     ];
        $items = Gatetraffic::where(function ($query) use ($request) {
                                if (! is_null ($request->startDate) && ! is_null($request->endDate)){
                                      $query->orWhereBetween('gatedate', $dateRange);
                                }
                            })
                            ->join('users', function($join) use ($request)
                                {
                                    $join->on ('users.id', '=', 'gatetraffics.user_id');

                                    if (! is_null ($request->code)){
                                            $join->where('users.code', '=', $request->code);
                                    }
                                })
                            ->join('cards', function($join) use ($request)
                            {
                                $join->on ('cards.user_id', '=', 'users.id');

                                 if (! is_null ($request->cdn)){
                                        $join->where('cards.cdn', '=', $request->cdn);
                                    }

                            })
                            ->join('people', function($join) use ($request)
                            {
                                $join->on ('people.id', '=', 'users.people_id');

                                if (! is_null ($request->nationalId)){
                                    $join->where('people.nationalId', '=', $request->nationalId);
                                }

                                if (! is_null ($request->name)){
                                    $join->where('people.name', 'like', '%' . $request->name . '%');
                                }

                                if (! is_null ($request->lastname)){
                                    $join->where('people.lastname', 'like', '%' .  $request->lastname . '%');
                                }
                            })

                            ->join('gatedevices', 'gatedevices.id', '=', 'gatetraffics.gatedevice_id')
                            ->join('gatepasses', 'gatepasses.id', '=', 'gatetraffics.gatepass_id')
                            ->join('gatedirects', 'gatedirects.id', '=', 'gatetraffics.gatedirect_id')
                            ->join('gatemessages', 'gatemessages.id', '=', 'gatetraffics.gatemessage_id')
                            ->select([
                                'users.code as user_code',
                                'people.name as user_people_name',
                                'people.lastname as user_people_lastname',
                                'people.picture as user_people_picture',
                                'gatedevices.name as gatedevice_name',
                                'gatedirects.name as gatedirect_name',
                                'gatemessages.message as gatemessage_message',
                                'gatemessages.id as gatemessage_id',
                                'gatetraffics.gatedate as gatedate'

                        ])
                        ->paginate(Controller::C_PAGINATE_SIZE);

                 return new TrafficCollection($items);
    }

    public function searchMyTraffic(Request $request)
    {
        $group_id = $request->groupId;
        $code = $request->code;
        $gatemesage_id = $request->messageId;
        $gatedirect_id = $request->directId;
        $gatedevice_id = $request->deviceId;
        $gender_id = $request->genderId;
        $startDate = $request->beginDateTime;
        $endDate = $request->endDateTime;

        $commonRange_id = $request->commonrangeId;
        // IF filter = true : startDate and endDate
        // IF filter = false: Common range
        $filter = $request->type_filter;

        if (! $filter){
            $dateFilter =  static::getDateFilter($commonRange_id);
            $startDate = $dateFilter['startOfDate'];
            $endDate = $dateFilter['endOfDate'];
        }
        $dateRange =[
                        $startDate,
                        $endDate
                    ];

        $res = \App\Gatetraffic::whereBetween('gatedate',$dateRange);
        $res = $res->join ('users', 'gatetraffics.user_id', 'users.id')
                   ->join ('people', 'people.id', 'users.people_id')
                   ->join ('genders', 'genders.id', 'people.gender_id')
                   ->join ('groups', 'groups.id', 'users.group_id')
                   ->join('gatedevices', 'gatedevices.id', 'gatetraffics.gatedevice_id')
                   ->join('gatepasses', 'gatepasses.id', 'gatetraffics.gatepass_id')
                   ->join('gatedirects', 'gatedirects.id', 'gatetraffics.gatedirect_id')
                   ->join('gatemessages', 'gatemessages.id', 'gatetraffics.gatemessage_id');

        if (! is_null($group_id) && ($group_id > 0)){
            $res = $res->where('users.group_id', $group_id);
        }

        if (! is_null($code)){
            $res = $res->where('users.code','like', "%$code%");
        }

        if (!is_null ($gatemesage_id)) {
            $res = $res->Where ('gatemessages.id', '=', $gatemesage_id);
        }

        if (!is_null ($gatedevice_id)) {
            $res = $res->Where ('gatedevices.id', '=', $gatedevice_id);
        }

        if (!is_null ($gatedirect_id)) {
            $res = $res->Where ('gatedirects.id', '=', $gatedirect_id);
        }

        if (!is_null ($gender_id)) {
            $res = $res->Where ('genders.id', '=', $gender_id);
        }

        $res = $res->select ('gatetraffics.gatedate as gatetraffic_gatedate',
                            'gatemessages.message as gatemessage_name',
                            'gatedirects.name as gatedirect_name',
                            'genders.gender as gender_name',
                            'groups.name as group_name',
                            'users.code as user_code',
                            'people.name as people_name',
                            'people.lastname as people_lastname',
                            'people.nationalId as people_nationalId'
                        )
                     ->paginate(Controller::C_PAGINATE_SIZE);
                     // \DB::raw('count(gatetraffics.id) as traffic_count'),
        return new ReportCollection($res);
    }

}
