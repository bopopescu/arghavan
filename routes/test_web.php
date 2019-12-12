<?php
// use Illuminate\Support\Facades\DB;

Route::view('clock', 'report-test');
Route::view('ipass', 'referrals.test');
Route::get('who',function () {

        \App\Jobs\GetTrafficRemoteRaspberry::dispatch();
        return "success";
});

// Route::get('upload', 'PeopleController@upload');
Route::get('get-identify', 'API\PassportController@getIdentify');
Route::get('test', function () {

        $card = \App\Card::leftjoin('card_user', 'card_id', 'cards.id')
                            ->where ('cdn', '1046343769')
                            ->select([ 
                                'card_user.card_id',
                                'card_user.user_id',
                                'cdn',
                                'state',
                                'startDate',
                                'endDate',
                                'cardtype_id'
                            ])
                            ->get ()
                            ->first ();
        return $card;


        $res = \App\User::leftjoin('card_user', 'user_id', 'users.id')
                        ->leftjoin('cards', 'card_id', 'cards.id')
                        ->where('users.id', 3)
                        ->select([
                                    'users.id as userId', 
                                    'card_user.user_id', 
                                    'card_user.card_id' ,
                                    'cards.cdn', 
                                    'cards.state',
                                    'cards.startDate',
                                    'cards.endDate',
                                    'cards.cardtype_id'
                                ])
                        ->get()
                        ->first();

      
       
        return $res;




        $groupId = 3;
        $cardtypeId = 2;

         $fun = [
            'group' => function($q) {
                $q->select([
                    'id',
                    'name'
                ]);
            },

            'people' => function($q) {
                $q->select([
                    'id',
                    'name',
                    'lastname',
                    'nationalId'
                ]);
            },

            'cards' => function($q) use($cardtypeId) {
                $q->where('cardtype_id', $cardtypeId);
                $q->select([
                    'id',
                    'cdn',
                    'startDate',
                    'state',
                    'endDate',
                    'cardtype_id',
                ]);
            },

            'cards.cardtype' => function($q) {
                $q->select([
                    'id',
                    'name'
                ]);
            },
        ];
       

});

/* TEST */

// Route::get('suprima', function(){

//     $code = '2';
//         $fun = [
//             'people' => function($query){
//                  $query->select([
//                     'id',
//                     'name',
//                     'lastname',
//                     'nationalId'
//                     ]);
//                 },
//             ];

//         $items = \App\User::wherehas('people')
//                 ->leftJoin('fingerprints', 'fingerprints.user_id', 'users.id', function($query) use ($code){
//                     $query->Where('fingerprints.fingerprint_user_id', $code);
//                 })
//                 ->with($fun)
//                 ->select(['users.id as user_id',
//                             'users.code as user_code',
//                             'groups.name as group_name',
//                             'people_id as people_id',
//                             'fingerprints.id as fingerprint_id',
//                             'fingerprints.fingerprint_user_id as fingerprint_user_id',
//                             'fingerprints.image as fingerprint_image',
//                             'fingerprints.template as fingerprint_template',
//                         ])
//                 ->get();



//         return $items;
// });




Route::get('send-sms', function () {
    $lang_code = App::getLocale();
     // dd($lang_code);
     // Config::get('app.locale')
    dd(Config::get('app.locale'));
    // \App\Jobs\ProcessSendSMS::dispatch ('+989128812298', 'my message comes here', 1);
});


/*  END: TEST  */
