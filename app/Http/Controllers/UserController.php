<?php

namespace App\Http\Controllers;

use App\UserInfo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // url argument
        $name = $request->input('name', "");
        $gender = $request->input('gender', "");
        $department = $request->input('department', "");
        $grade = $request->input('grade', "");
        $score = $request->input('score');

        // start query
        $users = UserInfo::where('score', '>=', $score)
                         ->when($name, function($query) use ($name) {
                            return $query->where("name", $name);
                         })
                         ->when($gender, function($query) use ($gender) {
                            return $query->where("gender", $gender);
                         })
                         ->when($department, function($query) use ($department) {
                            return $query->where("department", $department);
                         })
                         ->when($grade, function($query) use ($grade) {
                            if($grade == '5') {
                                return $query->where("grade", '>=', $grade);
                            } else {
                                return $query->where("grade", $grade);
                            }
                         })
                         ->with('skills', 'departmentDetail')
                         ->get();
        foreach($users as $user) {
            // departmentDetail replace department
            // departmentDetail has ch and en name of department
            $user->department = $user->departmentDetail;
            // translate gender to chinese
            if($user->gender == 'female') {
                $user->gender = "女";
            } else if($user->gender == 'male') {
                $user->gender = "男";
            } else {
                $user->gender = "未知";
            }
            // convert image
            $user->propic = base64_encode( $user->propic);
        }
        echo $users->toJson();
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
}

