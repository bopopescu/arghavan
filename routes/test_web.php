<?php
// use Illuminate\Support\Facades\DB;

Route::view('ipass', 'referrals.test');
// Route::get('upload', 'PeopleController@upload');
//Route::get('test', 'AmoebaController@listAllowTraffic');
// Route::get('get-fingerprint-user', 'API\PassportController@getFingerprintUser');
Route::get('test', function () {
     $group_id = 3;
        $search = '';
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
                    'nationalId',
                    'birthdate',
                    'mobile',
                    'phone',
                    'address',
                    'gender_id',
                    'city_id',
                    'melliat_id',
                    'picture'
                ]);
            },
            'people.gender' => function($query){
                $query->select([
                    'id',
                    'gender'
                ]);
            },
            'people.melliat' => function($query){
                $query->select([
                    'id',
                    'name'
                ]);
            },
            'people.city' => function($query){
                $query->select([
                    'id',
                    'name',
                    'province_id'
                ]);
            },
            'people.city.province' => function($query){
                $query->select([
                    'id',
                    'name'
                ]);
            },
            // 'terms' => function ($query){
            //     $query->select([
            //         'id',
            //         'year',
            //         'semester_id'
            //     ]);
            // },
            'terms.semester' => function ($query){
                $query->select([
                    'id',
                    'name'
                ]);
            },
            'student' => function($query){
                $query->select([
                    'id',
                    'user_id',
                    'degree_id',
                    'field_id',
                    'part_id',
                    'situation_id'
                ]);
            },
            'student.degree' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'student.field' => function($query){
                $query->select([
                    'id',
                    'name',
                    'university_id'
                ]);
            },
            'student.field.university' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'student.part' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'student.situation' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'teacher' => function($query){
                $query->select([
                    'id',
                    'user_id',
                    'semat'
                ]);
            },
            'staff' => function($query){
                $query->select([
                    'id',
                    'user_id',
                    'department_id',
                    'contract_id'
                ]);
            },
            'staff.department' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'staff.contract' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'grouppermits' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
            'gategroups' => function($query){
                $query->select([
                    'id',
                    'name',
                ]);
            },
        ];
        $res = \App\User::where('group_id', $group_id)
                    ->whereHas('people' , function($q) use($search) {
                        if (! is_null($search)){
                            $q->where('users.code', 'like', "%$search%");
                            $q->orwhere ('people.name', 'like' , "%$search%");
                            $q->orwhere ('people.lastname', 'like' , "%$search%");
                            $q->orwhere ('people.nationalId', 'like' , "%$search%");
                        }
                    })
                    // ->orWhereHas('terms')
                    // ->orWhereHas('grouppermits')
                    // ->orWhereHas('gategroups')
                    ->leftjoin('students', 'students.user_id', 'users.id')
                    ->leftjoin('teachers', 'teachers.user_id', 'users.id')
                    ->leftjoin('staff', 'staff.user_id', 'users.id')
                    ->with($fun)
                    ->select(['users.id', 'code', 'email', 'state', 'level_id', 'people_id', 'group_id'])
                    ->get();

        return $res;
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
