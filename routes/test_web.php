<?php
// use Illuminate\Support\Facades\DB;

Route::view('ipass', 'referrals.test');
Route::get('who',function () {

        \App\Jobs\GetTrafficRemoteRaspberry::dispatch();
        return "success";
});

// Route::get('upload', 'PeopleController@upload');
Route::get('get-identify', 'API\PassportController@getIdentify');
Route::get('test', function () {
    $res = \App\Fingerprint::where('user_id', 3)
                            ->get();

    $pic = Image::make($res[0]->image)->resize(320, 240);
    $response = Response::make($pic->encode('jpeg'));

    //setting content-type
    $response->header('Content-Type', 'image/jpeg');

    return $response;

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
