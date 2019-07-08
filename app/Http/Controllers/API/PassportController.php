<?php

namespace App\Http\Controllers\API;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Cardtype;
use App\Group;
use Carbon\Carbon;

class PassportController extends Controller
{
    public $successStatus = 200;
    public $failedStatus  = 401;

    /**
     * Constructor
     */
    public function __construct ()
    {
    }


    public function test()
    {
        return 'ok';
    }
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login ()
    {
        $fields = [
            'code'    => request('code'),
            'password' => request('password')
        ];

        if (Auth::attempt ($fields))
        {
            $user = Auth::user();

            $user->load('people');

            $success['token'] = $user->createToken ('MyApp')
                                     ->accessToken;

            $fields = [
                'success' => $success
            ];

            return response()->json ($fields,
                                     $this->successStatus);
        }
        else
        {
            $fields = [
                'error' => 'Unauthorised'
            ];

            return response()->json ($fields,
                                     401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register (Request $request)
    {
        $criteria = [
            'name'       => 'required',
            'email'      => 'required|email',
            'password'   => 'required',
            'c_password' => 'required|same:password',
        ];

        $validator = Validator::make ($request->all (),
                                      $criteria);

        if ($validator->fails ())
        {
            $fields = [
                'error' => $validator->errors()
            ];

            return response()->json($fiedls,
                                    401);
        }
        $input             = $request->all ();
        $input['password'] = bcrypt ($input['password']);
        $user              = User::create ($input);

        $success['token']  = $user->createToken ('MyApp')
                                  ->accessToken;
        $success['name']   = $user->name;

        return response ()->json (['success' => $success],
                                   $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails ()
    {
        $user = Auth::user();

        $user->load('people');

        $fields = ['success' => $user];

        return response()->json($fields,
                                 $this->successStatus);
    }

    /**
     * Logout
     */
    public function logout (Request $request)
    {
        if (! \Auth::check ())
        {
            $fields = ['failed' => 'NO USER'];

            return response()->json($fields,
                                    $this->faiuledStatus);
        }

        // Try to logout
        $user = \Auth::user();
        $id   = $user->id;
        $name = $user->name;

        // Revoke token
        $updateFields = [
            'revoked' => true
        ];

        $token = \DB::table ('oauth_access_tokens')
                    ->where ('user_id', $id)
                    ->update ($updateFields);

        // Setup result
        $fields = [
            'success' => $name
        ];

        return response()->json($fields,
                                $this->successStatus);
    }

    /**
     * Get Card Type
     */
    public function getData()
    {
        $cardtype = Cardtype::all();
        $group = Group::all();
        $resultCardtype = \App\Http\Resources\CardTypeResource::collection ($cardtype);
        $resultGroup = \App\Http\Resources\CardTypeResource::collection ($group);

        $fields = ['successCardType' => $resultCardtype,
                    'successGroup' => $resultGroup];

        $result = response()->json($fields,
                                   $this->successStatus);

        return $result;
    }

     /**
     * Search User Report
     */
    public function searchUser(Request $request)
    {
        $code = $request->code;
        $items = User::join('people','people.id', '=', 'users.people_id')
                ->join('groups', 'groups.id', '=', 'users.group_id')
                ->leftJoin('cards', 'cards.user_id', '=', 'users.id')
                ->orWhere('users.code', '=', $code)
                ->orWhere('people.nationalId', '=', $code)
                ->select([
                    'groups.name as group_name',
                    'groups.id as group_id',
                    'users.id as user_id',
                    'users.code as user_code',
                    'users.state as user_state',
                    'people.id as people_id',
                    'people.name as people_name',
                    'people.lastname as people_lastname',
                    'people.nationalId as people_nationalId',
                    'cards.cdn as card_cdn',
                    'cards.cardtype_id as card_type_id',
                    'cards.state as card_state',
                    'cards.endDate as card_endDate'
                ])
                ->get();

                $resultUser = \App\Http\Resources\SearchUserResource::collection ($items);

                $fields = ['success' => $resultUser];

                $result = response()->json($fields,
                                   $this->successStatus);

        return ($result);
    }

    /**
     * Update/ Create user
     */
    public function updateUser(Request $request)
    {
        // Check CDN
        $card = \App\Card::where ('cdn', $request->card_cdn)
                         ->get ()
                         ->first ();

        // Card Exists
        if (! is_null ($card))
        {
            $user_id = $request->user_id;
            // Card is assigned to user
            if ($card->user_id == $user_id)
            {
                 $card->update([
                        'cdn'           => $request->card_cdn,
                        'state'         => $request->card_state,
                        'startDate'     => $request->card_startDate,
                        'endDate'       => $request->card_endDate,
                        'group_id'      => $request->group_id,
                        'cardtype_id'   => $request->card_type_id,
                    ]);
            }
            else
            {
                $fieldsError = [
                    'success' => ['code' => $request->user_id]
                ];


                return response()->json($fieldsError,
                                    $this->failedStatus);
            }
        }
        // Card not Exists
        else
        {
             // Check User_id in Card table
             $user_card = \App\Card::where ('user_id', $request->user_id)
                             ->get ()
                             ->first ();

             // Update Card
            if (! is_null($user_card))
            {
                $user_card->update([
                        'cdn'           => $request->card_cdn,
                        'state'         => $request->card_state,
                        'startDate'     => $request->card_startDate,
                        'endDate'       => $request->card_endDate,
                        'group_id'      => $request->group_id,
                        'cardtype_id'   => $request->card_type_id,
                    ]);
            }
            else
            {
                $data = [
                            'cdn'         => $request->card_cdn,
                            'user_id'     => $request->user_id,
                            'state'       => $request->card_state,
                            'startDate'   => $request->card_startDate,
                            'endDate'     => $request->card_endDate,
                            'group_id'    => $request->group_id,
                            'cardtype_id' => $request->card_type_id
                        ];

                 // Insert Card
                $card = \App\Card::create($data);
            }
        }

        // Setup result
        $result = [
            'status' => $this->successStatus,
            'success' => ['code' => $request->user_id]
        ];

        // $result = response()->json($fields,
        //                            $this->successStatus);

        return ($result);
    }

    /**
     * Gets the data fingerprint.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    The data fingerprint.
     */
    public function getFingerprintUser(Request $request)
    {
       $code = $request->code;
        $fun = [
            'people' => function($query){
                 $query->select([
                    'id',
                    'name',
                    'lastname',
                    'nationalId'
                    ]);
                },
            ];

        $items = \App\User::wherehas('people',function($query) use($code){
                    $query->Where('users.code', $code);
                    $query->orWhere('people.nationalId', $code);
                })
                ->join('groups', 'groups.id', '=', 'users.group_id')
                ->leftJoin('fingerprints', 'fingerprints.user_id', 'users.id')
                ->with($fun)
                ->select(['users.id as user_id',
                            'users.code as user_code',
                            'groups.name as group_name',
                            'groups.id as group_id',
                            'people_id as people_id',
                            'fingerprints.id as fingerprint_id',
                            'fingerprints.fingerprint_user_id as fingerprint_user_id',
                            'fingerprints.image as fingerprint_image',
                            'fingerprints.template as fingerprint_template',
                        ])
                ->get();

                $resultUser = \App\Http\Resources\FingerprintDataResource::collection ($items);
                $fields = ['success' => $resultUser];

                $result = response()->json($fields,
                                   $this->successStatus);
                // ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
        return $result;
    }
    /**
     * Stores a fingerprint.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function storeFingerprintUser(Request $request)
    {
        $newFingerprint = \App\Fingerprint::create([
                    'user_id'               => $request->user_id,
                    'fingerprint_user_id'   => $request->fingerprint_user_id,
                    'image'                 => $request->fingerprint_image,
                    'image_quality'         => $request->fingerprint_quality,
                    'template'              => $request->fingerprint_template,
                ]);

        $fieldsError = [
                    'success' => ['success' => $newFingerprint->id]
                ];

        return response()->json($fieldsError,
                                $this->successStatus);
    }

    public function updateImageFingerprint(Request $request)
    {
        // dd($request->fingerprint_image);
        $fingerprint = \App\Fingerprint::where('user_id', $request->user_id)
                                    ->first();

         // Card Exists
        if (! is_null ($fingerprint))
        {
            $fingerprint->update([
                'image' => $request->fingerprint_image
            ]);
        }

        $fields = [
                    'success' => ['success' => $fingerprint->id]
                ];

        return response()->json($fields,
                                $this->successStatus);
    }


    public function getIdentifyFingerprint(Request $request)
    {

       $code = $request->fp_user_id;
        $fun = [
            'people' => function($query){
                 $query->select([
                    'id',
                    'name',
                    'lastname',
                    'nationalId'
                    ]);
                },
            ];

        $items = \App\User::wherehas('people')
                ->leftJoin('fingerprints', 'fingerprints.user_id', 'users.id', function($query) use ($code){
                    $query->Where('fingerprints.fingerprint_user_id', $code);
                })
                ->with($fun)
                ->select(['users.id as user_id',
                            'users.code as user_code',
                            'groups.name as group_name',
                            'people_id as people_id',
                            'fingerprints.id as fingerprint_id',
                            'fingerprints.fingerprint_user_id as fingerprint_user_id',
                            'fingerprints.image as fingerprint_image',
                            'fingerprints.template as fingerprint_template',
                        ])
                ->get();

                $resultUser = \App\Http\Resources\FingerprintDataResource::collection ($items);
                $fields = ['success' => $resultUser];

                $result = response()->json($fields,
                                   $this->successStatus);
                // ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE
        return $result;
    }


}

