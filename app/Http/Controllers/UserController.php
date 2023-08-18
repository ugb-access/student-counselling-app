<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $search_keyword = $request->query('search');
        $page = $request->query('page', 1);

        
        if(empty($limit)) {
            $all_users = User::where('role_id', 2)->latest()->paginate(10, ['*'], 'page', $page);
        } else {
            if($search_keyword && !empty($search_keyword)) {
                
                $all_users = User::where('role_id', 2)
                ->where(function ($query) use ($search_keyword) {
                    $query->where('name', 'like', '%' . $search_keyword . '%');
                        
                })
                ->take($limit)
                ->get();
            } else {
                $all_users = User::where('role_id', 2)->orderBy("created_at", "desc")->limit($limit)->get();
            }
            
        }
        if($all_users && count($all_users) > 0) {
            return response()->json(['data' => $all_users], 200);
        } else {
            return response()->json(['data' => []], 200);
        }
       
    }

    public function get_student_list(Request $request) {
        $limit = $request->query('limit');
        $page = $request->query('page', 1);
        $status = $request->query('status');
        $user = Auth::user();

      
        if($user->role_id === 1) {
            if(empty($limit)) {
                if(empty($status)) {
                    $all_users = User::with('student')->where('role_id', 3)->latest()->paginate(10, ['*'], 'page', $page);
                } else {
                    $status_bol = $status === "incomplete" ? 0 : 1;
                    $all_users = User::with('student')->where('role_id', 3)->whereHas('student', function ($query) use ( $status_bol) {
                        $query->where('payment_status', $status_bol);
                    })->latest()->paginate(10, ['*'], 'page', $page);
                }
                
            } else {
                $all_users = User::where('role_id', 3)->orderBy("created_at", "desc")->limit($limit)->get();
            }
        } else {
            if(empty($limit)) {
                if(empty($status)) {
                    $all_users = User::with('student')->where('role_id', 3)->where('added_by_user_id', $user->id)->latest()->paginate(10, ['*'], 'page', $page);
                } else {
                    $status_bol = $status === "incomplete" ? 0 : 1;
                    $all_users = User::with('student')->where('role_id', 3)->where('added_by_user_id', $user->id)->whereHas('student', function ($query) use ( $status_bol) {
                        $query->where('payment_status', $status_bol);
                    })->latest()->paginate(10, ['*'], 'page', $page);
                }
                
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
            ->whereIn('role_id', [1, 2, 3]) 
            ->groupBy('role_id')
            ->get();

            $student_with_payment_proof = Student::where('payment_status', 1)->count();
            
            $currentMonthCount = User::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count();
    
            // Get the count of users for the previous month
            $previousMonthCount = User::whereYear('created_at', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count();
            return response()->json(['data' => ['overall_user' => $user_count, 'current_month' => $currentMonthCount, 'previous_month' => $previousMonthCount, 'student_with_payment_proof' => $student_with_payment_proof]], 200);
        }

        if($user->role_id === 2) {
            $user_count = User::where('role_id', 3)
            ->where('added_by_user_id', $user->id)
            ->count();

            $student_with_payment_proof = User::where('added_by_user_id', $user->id)->whereHas('student', function ($query) {
                $query->where('payment_status', 1);
            })
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
            return response()->json(['data' => ['overall_user' => [[ 'role_id' => 3, 'count' => $user_count]], 'current_month' => $currentMonthCount, 'previous_month' => $previousMonthCount, 'student_with_payment_proof' => $student_with_payment_proof]], 200);
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

    


    public function update_profile(Request $request) {
        
        $user = auth()->user();
        $data = $request->all();
        if($user->role_id === 1 || $user->role_id === 2) {
            $validator = Validator::make($data, [
                'name' => 'string',
                'phone_number' => '|string|max:20',
            ]);
            if($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            } 

            if(isset($data["name"])){
                $user->name = trim($data["name"]);
            }
            if(isset($data["phone_number"])){
                $user->phone_number = trim($data["phone_number"]);
            }


            $user->save();

            return response()->json(['message' => 'Profile Updated successfully'], 200);
            
        }
    }


    public function update_user_profile(Request $request, User $user) {
        $logged_in_user = auth()->user();

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'string',
            'phone_number' => '|string|max:20',
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        } 

        
        if($logged_in_user->id !== $user->id) {
            if($logged_in_user->role_id === 1) {
                if(isset($data["name"])){
                    $user->name = trim($data["name"]);
                }
                if(isset($data["phone_number"])){
                    $user->phone_number = trim($data["phone_number"]);
                }

                
    
                $user->save();
    
                return response()->json(['message' => 'Profile Updated successfully'], 200);
            } else if($logged_in_user->role_id === 2 && $user->added_by_user_id === $logged_in_user->id) {
                if(isset($data["name"])){
                    $user->name = trim($data["name"]);
                }
                if(isset($data["phone_number"])){
                    $user->phone_number = trim($data["phone_number"]);
                }
    
                $user->save();
    
                return response()->json(['message' => 'Profile Updated successfully'], 200);
            } else {
                return response()->json(['message' => 'Something went wrong.Please Try Again.'], 400);
            }
        }

    }


    public function delete_user_profile(Request $request, User $user) {
        $logged_in_user = auth()->user();
        if($logged_in_user->role_id === 1) {
            $user->delete();
            return response()->json(['message' => 'User deleted'], 200);
            
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
       
    }
    
}
