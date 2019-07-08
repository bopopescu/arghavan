<?php

namespace App\Http\Controllers;

use App\Student;
use App\Degree;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $student = Student::with('degree')
        //         ->paginate(Controller::C_PAGINATE_SIZE);
        // dd($student);
        if ($request->ajax())
        {
            $student = Student::with('degree')
                ->paginate(Controller::C_PAGINATE_SIZE);

            return $student;
        }
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
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

     public function studentChart()
    {
        $labels = [];
        $series = [];
        $group_id = \App\People::$GROUP_STUDENTS;
        $res_all = \App\User::where('group_id', $group_id)
                            ->whereHas('people')
                            ->join('students', 'students.user_id', 'users.id')
                            ->count();
       $labels[] = "کل";
       $series[] = $res_all;

        $res_has_card = \App\User::where('group_id', $group_id)
                                ->whereHas('people')
                                ->whereHas('cards')
                                ->join('students', 'students.user_id', 'users.id')
                                ->count();
        $labels[] = "دارای کارت";
        $series[] = $res_has_card;

       $res_Dont_have_card = \App\User::where('group_id', $group_id)
                                        ->whereHas('people')
                                        ->whereDoesntHave('cards')
                                        ->join('students', 'students.user_id', 'users.id')
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
