<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    
    public function get_admin_list(Request $request) {
        $limit = $request->query('limit');

        
       
        if(empty($limit)) {
            $all_users = User::where('role_id', 1)->orderBy("created_at", "desc")->get();
        } else {
            $all_users = User::where('role_id', 1)->orderBy("created_at", "desc")->limit($limit)->get();
        }

        return response()->json(['data' => $all_users], 200);
    }

    public function get_counsellor_list(Request $request) {
        $limit = $request->query('limit');
       
        if(empty($limit)) {
            $all_users = User::where('role_id', 2)->orderBy("created_at", "desc")->get();
        } else {
            $all_users = User::where('role_id', 2)->orderBy("created_at", "desc")->limit($limit)->get();
        }
        return response()->json(['data' => $all_users], 200);
    }

    public function get_student_list(Request $request) {
        $limit = $request->query('limit');
        $user = Auth::user();
      
        if($user->role_id === 1) {
            if(empty($limit)) {
                $all_users = User::where('role_id', 3)->orderBy("created_at", "desc")->get();
            } else {
                $all_users = User::where('role_id', 3)->orderBy("created_at", "desc")->limit($limit)->get();
            }
        } else {
            if(empty($limit)) {
                $all_users = User::where('role_id', 3)->where('added_by_user_id', $user->id)->orderBy("created_at", "desc")->get();
            } else {
                $all_users = User::where('role_id', 3)->where('added_by_user_id', $user->id)->orderBy("created_at", "desc")->limit($limit)->get();
            }
        }
        
        return response()->json(['data' => $all_users], 200);
    }



    public function get_user_count(Request $request) {
        
        $user = Auth::user();
        if($user->role_id === 1) {
            $user_count = User::selectRaw('role_id, COUNT(*) as count')
            ->whereIn('role_id', [1, 2, 3]) // Assuming role_id 1 is for admins, 2 for counselors, and 3 for students
            ->groupBy('role_id')
            ->get();
            // Get the count of users for the current month
            $currentMonthCount = User::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count();
    
            // Get the count of users for the previous month
            $previousMonthCount = User::whereYear('created_at', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count();
            return response()->json(['data' => ['overall_user' => $user_count, 'current_month' => $currentMonthCount, 'previous_month' => $previousMonthCount]], 200);
        }

        if($user->role_id === 2) {
            $user_count = User::where('role_id', 3)
            ->where('added_by_user_id', $user->id)
            ->count();
            // Get the count of users for the current month
            $currentMonthCount = User::where('role_id', 3)
            ->where('added_by_user_id', $user->id)->whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count();
    
            // Get the count of users for the previous month
            $previousMonthCount = User::where('role_id', 3)
            ->where('added_by_user_id', $user->id)->whereYear('created_at', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count();
            return response()->json(['data' => ['overall_user' => [[ 'role_id' => 3, 'count' => $user_count]], 'current_month' => $currentMonthCount, 'previous_month' => $previousMonthCount]], 200);
        } 
    }


    public function get_profile(Request $request, $id) {
        $user = $request->user();
        if($user->role_id === 1) {
            $db_user = User::find((int)$id);
            if($db_user) {
                return response()->json(['data' => $db_user], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return response()->json(['data' => $db_user], 200);
        } else if($user->role_id === 2) {
            if($user->id === (int)$id) {
                $db_user = User::find((int)$id);
                return response()->json(['data' => $db_user], 200);
            } else {
                $db_user = User::where('id', (int)$id)->where('added_by_user_id', $user->id)->first();
                if($db_user) {
                    return response()->json(['data' => $db_user], 200);
                } else {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }
            }
            
        } else {
            if($user->id === (int)$id) {
                $db_user = User::find((int)$id);
                return response()->json(['data' => $db_user], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }
    }
    
}
