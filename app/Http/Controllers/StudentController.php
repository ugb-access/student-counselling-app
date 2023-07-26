<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function get_student_detail(Request $request, $id) {
        $student_id = $id;
        $user = $request->user();

        if($user && !empty($user)) {
            if($user->role_id === 1) {
                // admin    
                $student = User::with('student')->find($student_id);
                if($student) {
                    return response()->json(['data' => $student], 200);
                } else {
                    return response()->json(['message' => 'Record Not Found'], 400);
                }
            }
            if($user->role_id === 2) {
                $student = User::with('student')->find($id);
                dd($student);
                // if($is_counsellor_student) {
                //     return response()->json(['data' => $user], 200);
                // } else {
                //     return response()->json(['message' => 'Record Not Found'], 400);
                // }
            }

        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }


    public function store_student_detail(Request $request) {
        $data = $request->all();
        $path = public_path('storage/photo_files/t28bUe7DerUWxRiSmdA16MotQldPgid7KQva5xql.jpg'); 
        $fullUrl = Storage::url('photo_files/t28bUe7DerUWxRiSmdA16MotQldPgid7KQva5xql.jpg');
        dd(url($fullUrl));
        // dd(public_path('storage/' . 'photo_files/t28bUe7DerUWxRiSmdA16MotQldPgid7KQva5xql.jpg'));
        
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'photo_path' => 'required|mimes:jpeg,png,jpg|max:2048',
            'full_name' => 'required|string',
            'email' => 'required|email|max:255|unique:student',
            'nationality' => 'required|string|max:255',
            'marital_status' => 'required|integer|in:1,2', 
            'gender' => 'required|integer|in:1,2',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'passport_no' => 'required|string|max:50',
            'expiry_date' => 'required|date',
            'place_of_issue' => 'nullable|string|max:255',
            'address' => 'required',
            'phone' => 'required|string|max:35',
            'mobile' => 'required|string|max:35', 
            'mobile_2' => 'required|string|max:35',
            'referee_name' => 'required|string',
            'referee_mobile' => 'nullable|string|max:35',
            'document_correction' => 'nullable|string|max:255',
            'education_history' => 'required|array', 
            'semester_year' => 'required|integer|in:1,2,3,4',
            'country_detail' => 'required|array',


            'cv_path' => 'nullable|mimes:pdf|max:2048',
            'passport' => 'nullable|mimes:pdf|max:2048', 
            'english_test.*' => 'nullable|mimes:pdf',
            'academic_document' => 'nullable|mimes:pdf|max:2048',
            'teacher_reference' => 'nullable|mimes:pdf|max:2048',
            'cnic' => 'nullable|mimes:pdf|max:2048',
            'experience_letter' => 'nullable|mimes:pdf|max:2048',
            'other_certificates' => 'nullable|mimes:pdf|max:2048', 
            'conditional_offer' => 'nullable|mimes:pdf|max:2048',
            'unconditional_offer' => 'nullable|mimes:pdf|max:2048',
            'payment_proof' => 'nullable|mimes:pdf|max:2048',
            'cas_ecoe' => 'nullable|mimes:pdf|max:2048',
            'visa' => 'nullable|mimes:pdf|max:2048',
            'travel_plan' => 'nullable|mimes:pdf|max:2048',
            'gt_document' => 'nullable|mimes:pdf|max:2048',


        ]);

        // dd($validator);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        } 

        $student = new Student();

        $student->user_id = $request->input('user_id');
        
       
        
        $photo_path = $request->file('photo_path')->store('photo_files', 'public');
        $student->photo_path = $photo_path;
        
        $student->full_name = $request->input('full_name');
        $student->email = $request->input('email');

        $student->nationality = $request->input('nationality');

        $student->marital_status = $request->input('marital_status');

        $student->gender = $request->input('gender');

        $student->date_of_birth = $request->input('date_of_birth');

        $student->place_of_birth = $request->input('place_of_birth');

        $student->passport_no = $request->input('passport_no');

        $student->expiry_date = $request->input('expiry_date');

        $student->place_of_issue = $request->input('place_of_issue');

        $student->address = $request->input('address');

        $student->phone = $request->input('phone');

        $student->mobile = $request->input('mobile');

        $student->mobile_2 = $request->input('mobile_2');
        $student->referee_name = $request->input('referee_name');

        $student->referee_mobile = $request->input('referee_mobile');

        $student->document_correction = $request->input('document_correction');

        $student->education_history = $request->input('education_history');
        
        $student->semester_year = $request->input('semester_year');
        $student->country_detail = $request->input('country_detail');
        


        if($request->file('cv_path')) {
            $cvfileName = uniqid('cv' . '_') . '.' . $request->file('cv_path')->getClientOriginalExtension();
            $cv_path = $request->file('cv_path')->storeAs('cv_files', $cvfileName, 'public');
            $student->cv_path = $cv_path;
        } 

        if($request->file('passport')) {
            $passportfileName = uniqid('passport' . '_') . '.' . $request->file('passport')->getClientOriginalExtension();
            $passport = $request->file('passport')->storeAs('passport_files', $passportfileName, 'public');
            $student->passport = $passport;
        }


        if(count($request->file('english_test')) > 0) {
            $englishTestFiles = $request->file('english_test');

            // Initialize an array to store file paths
            $englishTestPaths = [];
    
            // Loop through each file in the array and store them
            foreach ($englishTestFiles as $key => $file) {
                // Generate a unique name for each file to avoid filename collisions
                $fileName = uniqid($key . '_') . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the desired location (e.g., 'english_test_files' folder within the 'public' disk)
                $filePath = $file->storeAs('english_test_files', $fileName, 'public');
    
                // Add the file path to the array
                $englishTestPaths[$key] = $filePath;
            }
    
           
            $student->english_test = $englishTestPaths;
        }
        
       if($request->file('academic_document')) {
            $academic_documentfileName = uniqid('academic_document' . '_') . '.' . $request->file('academic_document')->getClientOriginalExtension();
            $academic_document = $request->file('academic_document')->storeAs('academic_document_files', $academic_documentfileName, 'public');
            $student->academic_document = $academic_document;
       }


          
       if($request->file('cnic')) {
            $cnicfileName = uniqid('cnic' . '_') . '.' . $request->file('cnic')->getClientOriginalExtension();
            $cnic = $request->file('cnic')->storeAs('cnic_files', $cnicfileName, 'public');
            $student->cnic = $cnic;
       }


          
       if($request->file('teacher_reference')) {

            $teacher_referencefileName = uniqid('teacher_reference' . '_') . '.' . $request->file('teacher_reference')->getClientOriginalExtension();
            $teacher_reference = $request->file('teacher_reference')->storeAs('teacher_reference_files', $teacher_referencefileName, 'public');
            $student->teacher_reference = $teacher_reference;
       }

          
       if($request->file('experience_letter')) {

            $experience_letterfileName = uniqid('experience_letter' . '_') . '.' . $request->file('experience_letter')->getClientOriginalExtension();
            $experience_letter = $request->file('experience_letter')->storeAs('experience_letter_files', $experience_letterfileName, 'public');
            $student->experience_letter = $experience_letter;
       }



          
       if($request->file('other_certificates')) {
            $other_certificatesfileName = uniqid('other_certificates' . '_') . '.' . $request->file('other_certificates')->getClientOriginalExtension();
            $other_certificates = $request->file('other_certificates')->storeAs('other_certificates_files', $other_certificatesfileName, 'public');
            $student->other_certificates = $other_certificates;
       }


       


          
       if($request->file('conditional_offer')) {
            $conditional_offerfileName = uniqid('conditional_offer' . '_') . '.' . $request->file('conditional_offer')->getClientOriginalExtension();
            $conditional_offer = $request->file('conditional_offer')->storeAs('conditional_offer_files', $conditional_offerfileName, 'public');
            $student->conditional_offer = $conditional_offer;
       }


          
       if($request->file('unconditional_offer')) {
            $unconditional_offerfileName = uniqid('unconditional_offer' . '_') . '.' . $request->file('unconditional_offer')->getClientOriginalExtension();
            $unconditional_offer = $request->file('unconditional_offer')->storeAs('unconditional_offer_files', $unconditional_offerfileName, 'public');
            $student->unconditional_offer = $unconditional_offer;
       }

          
       if($request->file('payment_proof')) {

            $payment_prooffileName = uniqid('payment_proof' . '_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $payment_proof = $request->file('payment_proof')->storeAs('payment_proof_files', $payment_prooffileName, 'public');
            $student->payment_proof = $payment_proof;
       }





          
       if($request->file('cas_ecoe')) {

            $cas_ecoefileName = uniqid('cas_ecoe' . '_') . '.' .  $request->file('cas_ecoe')->getClientOriginalExtension();
            $cas_ecoe = $request->file('cas_ecoe')->storeAs('cas_ecoe_files', $cas_ecoefileName, 'public');
            $student->cas_ecoe = $cas_ecoe;
       }

          
       if($request->file('visa')) {

        $visafileName = uniqid('visa' . '_') . '.' . $request->file->getClientOriginalExtension();
        $visa = $request->file('visa')->storeAs('visa_files', $visafileName, 'public');
        $student->visa = $visa;
          

       }

          
       if($request->file('travel_plan')) {
            $travel_planfileName = uniqid('travel_plan' . '_') . '.' . $request->file('travel_plan')->getClientOriginalExtension();
            $travel_plan = $request->file('travel_plan')->storeAs('travel_plan_files', $travel_planfileName, 'public');
            $student->travel_plan = $travel_plan;
       }


       if($request->file('gt_document')) {
            $gt_documentfileName = uniqid('gt_document' . '_') . '.' . $request->file('gt_document')->getClientOriginalExtension();
            $gt_document = $request->file('gt_document')->storeAs('gt_document_files', $gt_documentfileName, 'public');
            $student->gt_document = $gt_document;
       }

        $student->save();
        return response()->json(['message' => 'Student record created successfully', 'data' => $student], 200);
    }


}
