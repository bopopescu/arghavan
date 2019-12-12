<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class UploaderController extends Controller
{
    public function __construct ()
    {
    }


    public function UploadData(Request $request)
    {
    	$image = $request->image;  // your base64 encoded

		if (! is_null($image)) {

    		$image = str_replace('data:image/jpeg;base64,', '', $image);
    		$image = base64_decode($image);

    		$resized_image = Image::make($image)->resize(100, 100);

    	//	$image->fit(320, 240);
			$th_name = str_replace('.jpg', '-t.jpeg', $resized_image);
			$pictureThumbUrl = storage_path('app/public') . '/' .($th_name);
			\File::put($pictureThumbUrl, $th_name);
		
            return $pictureThumbUrl;
        }

    	/*if (! is_null($image)) {

    		$image = str_replace('data:image/jpeg;base64,', '', $image);
    		$image = base64_decode($image);
        	$imageName = str_random(60).'.'.'jpg';
        	$imagePath = storage_path('app/public') . '/' . $imageName;

	        \File::put($imagePath, $image);
    	}
    	else {
    		$imageName = null;
    	}

    	$people = \App\People::withTrashed()
                            ->where('nationalId', $request->nationalId)
                            ->first();

        if (is_null($people))
    	{
        	$registerPeople = \App\People::create([
	                'name'       	=> $request->name,
	                'lastname'   	=> $request->lastname,
	                'nationalId' 	=> $request->nationalId,
	                'birthdate'  	=> $request->birthdate,
	                'father'  		=> $request->father,
	                'phone'      	=> $request->phone,
	                'mobile'     	=> $request->mobile,
	                'address'   	=> $request->address,
	                'gender_id'  	=> $request->gender_id,
	                'melliat_id' 	=> $request->melliat_id,
	                'city_id'   	=> $request->city_id,
	                'picture'    	=> $imageName,
                ]);

	        // Create new user
            $registerUser = \App\User::create([
                'code'      => $request->code,
                'email'     => $request->code . '@ikiu.ac.ir',
                'password'  => bcrypt(123456),
                'api_token' => str_random(60),
                'state'     => 1,
                'group_id'  => 3,
                'people_id' => $registerPeople->id,
                'level_id'  => 3,
            ]);

             // Create new Student
            $registerStudent = \App\Student::create([
                'term_id'   	=> 3,
                'native'       	=> 1,
                'suit'         => 0,
                'degree_id'    => $request->degree_id,
                'part_id'      => 1,
                'field_id'     => 1,
                'situation_id' => 1,
                'user_id'      =>  $registerUser->id,
            ]);

        	return [
	    		"success" => true,
	    		"data" => [
	    			"code" => $request->code
	    		]
	    	];

        }
        else
        {
    		return [
	    		"failed" => false,
	    		"data" => [
	    			"code" => $request->code
	    		]
	    	];
        }*/

	   

    }
}
