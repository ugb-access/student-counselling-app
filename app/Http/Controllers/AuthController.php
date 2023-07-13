<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        
        $data = $request->all();
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        $validator = Validator::make($data, [
            'username' => 'required_without_all:email',
            'email' => 'required_without_all:username|email',
            'password' => 'required|min:6|max:8',
        ]);
        
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } 
        $credentials = [];
        if(!empty($data['email'])) {
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password']
            ];
        } else {
            if(empty($data['username'])) {
                return response()->json(['error' => 'Email/Username is required'], 422);
            }
            $credentials = [
                'username' => $data['username'], 
                'password' => $data['password']
            ];
        }
        if (Auth::attempt($credentials, true)) {
            // Authentication successful
            // Generate and return authentication token or session cookie
            
            $user = '';
            if(!empty($credentials['email'])) {
                $user = User::where('email', $credentials['email'])->first();
            } else {
                $user = User::where('username', $credentials['username'])->first();
            }
          
            $token = $user->createToken('laravel')->plainTextToken;
            return response()->json([
                'message' => 'Authentication successful',
                'token' => $token,
            ], 200);
        } else {
            // Authentication failed
            // Return appropriate error response
            return response()->json(
                ['error' => 'Invalid credentials. Please check your email/username and password.'], 
                401
            );
        }


        
    }


    public function logout(Request $request) {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Authentication successful
            // Generate and return authentication token or session cookie
        } else {
            // Authentication failed
            // Return appropriate error response
        }
    }

   


    public function add_admin(Request $request) {
        
        $data = $request->all();
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        $validator = Validator::make($data, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:6|max:8',
        ]);
       
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } 

        User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'role_id' => 1
        ]);
    
        return response()->json(['message' => 'Admin created successfully'], 201);
    }

    public function add_counsellor(Request $request) {
        $data = $request->all();
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        $validator = Validator::make($data, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:6|max:8',
            'phone_number' => 'required|string|max:20',
        ]);
       
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } 

        
        User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'phone_number' => $data['username'],
            'role_id' => 2
        ]);
    
        return response()->json(['message' => 'Counsellor created successfully'], 201);
    }

    public function add_student(Request $request) {
        
        $data = $request->all();
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }
        $validator = Validator::make($data, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:6|max:8',
            'phone_number' => 'required|string|max:20',
        ]);
       
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } 

        User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'phone_number' => $data['phone_number'],
            'role_id' => 3
        ]);
    
        return response()->json(['message' => 'Student created successfully'], 201);
    }

   
}