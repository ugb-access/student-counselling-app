<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function get_admin_list(Request $request) {
        $all_users = User::where('role_id', 1)->get();
        return response()->json(['data' => $all_users], 201);
    }

    public function get_counsellor_list(Request $request) {
        $all_users = User::where('role_id', 2)->get();
        return response()->json(['data' => $all_users], 201);
    }

    public function get_student_list(Request $request) {
        $all_users = User::where('role_id', 3)->get();
        return response()->json(['data' => $all_users], 201);
    }
}
