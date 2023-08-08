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
                $student_data = User::with('student')->find($student_id);
                $s3_url = env('AWS_URL') . "/";
                
                if(!$student_data->student) {
                    return response()->json(['data' => $student_data], 200);
                }
                //required
                if($student_data->student->photo_path) {
                    $student_data->student->photo_path = $s3_url . $student_data->student->photo_path;
                }

                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . $student_data->student->cas_ecoe;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . $student_data->student->visa;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . $student_data->student->travel_plan;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . $student_data->student->gt_document;

                }

                $english_test_urls = [];
                if($student_data->student->english_test) {
                    foreach ($student_data->student->english_test as $key => $value) {
                        $english_test_urls[$key] =  $s3_url . $value;
                    }
    
                    $student_data->student->english_test = $english_test_urls;
                }
                

               
                return response()->json(['data' => $student_data], 200);
              
                   
                
            }
            if($user->role_id === 2) {
                $student_data = User::with('student')->find($student_id);
                $s3_url = env('AWS_URL');
                if($student_data->added_by_user_id !== $user->id) {
                    return response()->json(['data' => 'Not Authorized'], 400);
                }
                if(!$student_data->student) {
                    return response()->json(['data' => $student_data], 200);
                    
                } 
                //required
                $student_data->student->photo_path = $s3_url . $student_data->student->photo_path;

                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . $student_data->student->payment_proof;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . $student_data->student->payment_proof;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . $student_data->student->payment_proof;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . $student_data->student->payment_proof;

                }


               

               
                $english_test_urls = [];
                foreach ($student_data->student->english_test as $key => $value) {
                    $english_test_urls[$key] =  $s3_url . $value;
                }

                $student_data->student->english_test = $english_test_urls;


               
                if($student_data->student && $student_data->added_by_user_id === $user->id) {
                    
                    return response()->json(['data' => $student_data], 200);
                } 
            }
           
            if($user->id === (int)$student_id && $user->role_id === 3) {
                $student_data = User::with('student')->find($student_id);
                $s3_url = env('AWS_URL');
                
                if(!$student_data->student) {
                    return response()->json(['data' => $student_data], 200);
                    
                } 
                //required
                $student_data->student->photo_path = $s3_url . $student_data->student->photo_path;

                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . $student_data->student->payment_proof;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . $student_data->student->payment_proof;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . $student_data->student->payment_proof;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . $student_data->student->payment_proof;

                }


               

               
                $english_test_urls = [];
                foreach ($student_data->student->english_test as $key => $value) {
                    $english_test_urls[$key] =  $s3_url . $value;
                }

                $student_data->student->english_test = $english_test_urls;


               
                if($student_data->student) {
                    
                    return response()->json(['data' => $student_data], 200);
                } 
            }

        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }


    public function store_student_detail(Request $request) {
        $photo_file = $request->file('photo_path');
        
            $photo_filename = time() . '_' . uniqid('photo_path' . '_') . '_' . $photo_file->getClientOriginalName();
            
            $photo_file = $photo_file->storeAs('photo_files', $photo_filename, 's3');

           
        dd($photo_file, $request->file('photo_path'));

        $data = $request->all();
        
        $validator = Validator::make($data, [
            'user_id' => 'required|unique:student|exists:users,id',
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
            // 'education_history' => 'required|array', 
            'semester_year' => 'required|integer|in:1,2,3,4',
            // 'country_detail' => 'required|array',


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
        
        $photo_file = $request->file('photo_path');
        
        $photo_filename = time() . '_' . uniqid('photo_path' . '_') . '_' . $photo_file->getClientOriginalName();
        
        $photo_file = $photo_file->storeAs('photo_files', $photo_filename, 's3');
        $student->photo_path = $photo_file;
       
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

        $student->education_history = json_decode($data["education_history"], true);
        
        $student->semester_year = $request->input('semester_year');
        $student->country_detail = json_decode($data["country_detail"], true);
        


        if($request->file('cv_path')) {
            $cvfileName = uniqid('cv' . '_') . '.' . $request->file('cv_path')->getClientOriginalExtension();
            $cv_path = $request->file('cv_path')->storeAs('cv_files', $cvfileName, 's3');
            $student->cv_path = $cv_path;
        } 

        if($request->file('passport')) {
            $passportfileName = uniqid('passport' . '_') . '.' . $request->file('passport')->getClientOriginalExtension();
            $passport = $request->file('passport')->storeAs('passport_files', $passportfileName, 's3');
            $student->passport = $passport;
        }


        if($request->file('english_test') && count($request->file('english_test')) > 0) {
            $englishTestFiles = $request->file('english_test');

            // Initialize an array to store file paths
            $englishTestPaths = [];
    
            // Loop through each file in the array and store them
            foreach ($englishTestFiles as $key => $file) {
                // Generate a unique name for each file to avoid filename collisions
                $fileName = uniqid($key . '_') . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the desired location (e.g., 'english_test_files' folder within the 's3' disk)
                $filePath = $file->storeAs('english_test_files', $fileName, 's3');
    
                // Add the file path to the array
                $englishTestPaths[$key] = $filePath;
            }
    
           
            $student->english_test = $englishTestPaths;
        }
        
       if($request->file('academic_document')) {
            $academic_documentfileName = uniqid('academic_document' . '_') . '.' . $request->file('academic_document')->getClientOriginalExtension();
            $academic_document = $request->file('academic_document')->storeAs('academic_document_files', $academic_documentfileName, 's3');
            $student->academic_document = $academic_document;
       }


          
       if($request->file('cnic')) {
            $cnicfileName = uniqid('cnic' . '_') . '.' . $request->file('cnic')->getClientOriginalExtension();
            $cnic = $request->file('cnic')->storeAs('cnic_files', $cnicfileName, 's3');
            $student->cnic = $cnic;
       }


          
       if($request->file('teacher_reference')) {

            $teacher_referencefileName = uniqid('teacher_reference' . '_') . '.' . $request->file('teacher_reference')->getClientOriginalExtension();
            $teacher_reference = $request->file('teacher_reference')->storeAs('teacher_reference_files', $teacher_referencefileName, 's3');
            $student->teacher_reference = $teacher_reference;
       }

          
       if($request->file('experience_letter')) {

            $experience_letterfileName = uniqid('experience_letter' . '_') . '.' . $request->file('experience_letter')->getClientOriginalExtension();
            $experience_letter = $request->file('experience_letter')->storeAs('experience_letter_files', $experience_letterfileName, 's3');
            $student->experience_letter = $experience_letter;
       }



          
       if($request->file('other_certificates')) {
            $other_certificatesfileName = uniqid('other_certificates' . '_') . '.' . $request->file('other_certificates')->getClientOriginalExtension();
            $other_certificates = $request->file('other_certificates')->storeAs('other_certificates_files', $other_certificatesfileName, 's3');
            $student->other_certificates = $other_certificates;
       }


       


          
       if($request->file('conditional_offer')) {
            $conditional_offerfileName = uniqid('conditional_offer' . '_') . '.' . $request->file('conditional_offer')->getClientOriginalExtension();
            $conditional_offer = $request->file('conditional_offer')->storeAs('conditional_offer_files', $conditional_offerfileName, 's3');
            $student->conditional_offer = $conditional_offer;
       }


          
       if($request->file('unconditional_offer')) {
            $unconditional_offerfileName = uniqid('unconditional_offer' . '_') . '.' . $request->file('unconditional_offer')->getClientOriginalExtension();
            $unconditional_offer = $request->file('unconditional_offer')->storeAs('unconditional_offer_files', $unconditional_offerfileName, 's3');
            $student->unconditional_offer = $unconditional_offer;
       }

          
       if($request->file('payment_proof')) {

            $payment_prooffileName = uniqid('payment_proof' . '_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $payment_proof = $request->file('payment_proof')->storeAs('payment_proof_files', $payment_prooffileName, 's3');
            $student->payment_proof = $payment_proof;
       }





          
       if($request->file('cas_ecoe')) {

            $cas_ecoefileName = uniqid('cas_ecoe' . '_') . '.' .  $request->file('cas_ecoe')->getClientOriginalExtension();
            $cas_ecoe = $request->file('cas_ecoe')->storeAs('cas_ecoe_files', $cas_ecoefileName, 's3');
            $student->cas_ecoe = $cas_ecoe;
       }

          
       if($request->file('visa')) {

        $visafileName = uniqid('visa' . '_') . '.' . $request->file('visa')->getClientOriginalExtension();
        $visa = $request->file('visa')->storeAs('visa_files', $visafileName, 's3');
        $student->visa = $visa;
          

       }

          
       if($request->file('travel_plan')) {
            $travel_planfileName = uniqid('travel_plan' . '_') . '.' . $request->file('travel_plan')->getClientOriginalExtension();
            $travel_plan = $request->file('travel_plan')->storeAs('travel_plan_files', $travel_planfileName, 's3');
            $student->travel_plan = $travel_plan;
       }


       if($request->file('gt_document')) {
            $gt_documentfileName = uniqid('gt_document' . '_') . '.' . $request->file('gt_document')->getClientOriginalExtension();
            $gt_document = $request->file('gt_document')->storeAs('gt_document_files', $gt_documentfileName, 's3');
            $student->gt_document = $gt_document;
       }

        $student->save();
        return response()->json(['message' => 'Student record created successfully', 'data' => $student], 200);
    }




    public function update_student_detail(Request $request, Student $student) {
        $data = $request->all();
        
        $validator = Validator::make($data, [

            'photo_path' => 'mimes:jpeg,png,jpg|max:2048',
            'full_name' => 'string',
            'email' => 'email|max:255|unique:student',
            'nationality' => 'string|max:255',
            'marital_status' => 'integer|in:1,2', 
            'gender' => 'integer|in:1,2',
            'date_of_birth' => 'date',
            'place_of_birth' => 'string|max:255',
            'passport_no' => 'string|max:50',
            'expiry_date' => 'date',
            'place_of_issue' => 'nullable|string|max:255',
            'address' => 'string',
            'phone' => 'string|max:35',
            'mobile' => 'string|max:35', 
            'mobile_2' => 'string|max:35',
            'referee_name' => 'string',
            'referee_mobile' => 'nullable|string|max:35',
            'document_correction' => 'nullable|string|max:255',
            // 'education_history' => 'array', 
            'semester_year' => 'integer|in:1,2,3,4',
            // 'country_detail' => 'array',


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

       
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        } 



        if($request->file('photo_path') && !empty($request->file('photo_path'))) {
            $photo_file = $request->file('photo_path');
        
            $photo_filename = time() . '_' . uniqid('photo_path' . '_') . '_' . $photo_file->getClientOriginalName();
            
            $photo_file = $photo_file->storeAs('photo_files', $photo_filename, 's3');

            $student->photo_path = $photo_file;
        }

        
        if($request->input('full_name') && !empty($request->input('full_name'))) {
            $student->full_name = $request->input('full_name');
        }

        if($request->input('email') && !empty($request->input('email'))) {
            $student->email = $request->input('email');
        }


        if($request->input('nationality') && !empty($request->input('nationality'))) {
            $student->nationality = $request->input('nationality');
        }


        if($request->input('marital_status') && !empty($request->input('marital_status'))) {
            $student->marital_status = $request->input('marital_status');
        }


        if($request->input('gender') && !empty($request->input('gender'))) {
            $student->gender = $request->input('gender');
        }

        if($request->input('date_of_birth') && !empty($request->input('date_of_birth'))) {
            $student->date_of_birth = $request->input('date_of_birth');
        }


        if($request->input('place_of_birth') && !empty($request->input('place_of_birth'))) {
            $student->place_of_birth = $request->input('place_of_birth');
        }

        if($request->input('passport_no') && !empty($request->input('passport_no'))) {
            $student->passport_no = $request->input('passport_no');
        }

        if($request->input('expiry_date') && !empty($request->input('expiry_date'))) {
            $student->passport_no = $request->input('expiry_date');
        }


        if($request->input('place_of_issue') && !empty($request->input('place_of_issue'))) {
            $student->place_of_issue = $request->input('place_of_issue');
        }


        if($request->input('address') && !empty($request->input('address'))) {
            $student->address = $request->input('address');
        }

        if($request->input('mobile') && !empty($request->input('mobile'))) {
            $student->mobile = $request->input('mobile');
        }

        if($request->input('mobile_2') && !empty($request->input('mobile_2'))) {
            $student->mobile_2 = $request->input('mobile_2');
        }

        if($request->input('referee_name') && !empty($request->input('referee_name'))) {
            $student->referee_name = $request->input('referee_name');
        }

        if($request->input('referee_mobile') && !empty($request->input('referee_mobile'))) {
            $student->referee_mobile = $request->input('referee_mobile');
        }

        if($request->input('document_correction') && !empty($request->input('document_correction'))) {
            $student->document_correction = $request->input('document_correction');
        }


        if($request->input('education_history') && !empty($request->input('education_history'))) {
            $student->education_history = json_decode($request->input('education_history'), true);
        }


        if($request->input('semester_year') && !empty($request->input('semester_year'))) {
            $student->semester_year = $request->input('semester_year');
        }


        if($request->input('country_detail') && !empty($request->input('country_detail'))) {
            $student->country_detail = json_decode($request->input('country_detail'), true);
        }

        //optional fields



        if($request->file('cv_path')) {
            $cvfileName = uniqid('cv' . '_') . '.' . $request->file('cv_path')->getClientOriginalExtension();
            $cv_path = $request->file('cv_path')->storeAs('cv_files', $cvfileName, 's3');
            $student->cv_path = $cv_path;
        } 

        if($request->file('passport')) {
            $passportfileName = uniqid('passport' . '_') . '.' . $request->file('passport')->getClientOriginalExtension();
            $passport = $request->file('passport')->storeAs('passport_files', $passportfileName, 's3');
            $student->passport = $passport;
        }


        if($request->file('english_test') && count($request->file('english_test')) > 0) {
            $englishTestFiles = $request->file('english_test');

            // Initialize an array to store file paths
            $englishTestPaths = [];
    
            // Loop through each file in the array and store them
            foreach ($englishTestFiles as $key => $file) {
                // Generate a unique name for each file to avoid filename collisions
                $fileName = uniqid($key . '_') . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the desired location (e.g., 'english_test_files' folder within the 's3' disk)
                $filePath = $file->storeAs('english_test_files', $fileName, 's3');
    
                // Add the file path to the array
                $englishTestPaths[$key] = $filePath;
            }
    
           
            $student->english_test = $englishTestPaths;
        }
        
       if($request->file('academic_document')) {
            $academic_documentfileName = uniqid('academic_document' . '_') . '.' . $request->file('academic_document')->getClientOriginalExtension();
            $academic_document = $request->file('academic_document')->storeAs('academic_document_files', $academic_documentfileName, 's3');
            $student->academic_document = $academic_document;
       }


          
       if($request->file('cnic')) {
            $cnicfileName = uniqid('cnic' . '_') . '.' . $request->file('cnic')->getClientOriginalExtension();
            $cnic = $request->file('cnic')->storeAs('cnic_files', $cnicfileName, 's3');
            $student->cnic = $cnic;
       }


          
       if($request->file('teacher_reference')) {

            $teacher_referencefileName = uniqid('teacher_reference' . '_') . '.' . $request->file('teacher_reference')->getClientOriginalExtension();
            $teacher_reference = $request->file('teacher_reference')->storeAs('teacher_reference_files', $teacher_referencefileName, 's3');
            $student->teacher_reference = $teacher_reference;
       }

          
       if($request->file('experience_letter')) {

            $experience_letterfileName = uniqid('experience_letter' . '_') . '.' . $request->file('experience_letter')->getClientOriginalExtension();
            $experience_letter = $request->file('experience_letter')->storeAs('experience_letter_files', $experience_letterfileName, 's3');
            $student->experience_letter = $experience_letter;
       }



          
       if($request->file('other_certificates')) {
            $other_certificatesfileName = uniqid('other_certificates' . '_') . '.' . $request->file('other_certificates')->getClientOriginalExtension();
            $other_certificates = $request->file('other_certificates')->storeAs('other_certificates_files', $other_certificatesfileName, 's3');
            $student->other_certificates = $other_certificates;
       }


       


          
       if($request->file('conditional_offer')) {
            $conditional_offerfileName = uniqid('conditional_offer' . '_') . '.' . $request->file('conditional_offer')->getClientOriginalExtension();
            $conditional_offer = $request->file('conditional_offer')->storeAs('conditional_offer_files', $conditional_offerfileName, 's3');
            $student->conditional_offer = $conditional_offer;
       }


          
       if($request->file('unconditional_offer')) {
            $unconditional_offerfileName = uniqid('unconditional_offer' . '_') . '.' . $request->file('unconditional_offer')->getClientOriginalExtension();
            $unconditional_offer = $request->file('unconditional_offer')->storeAs('unconditional_offer_files', $unconditional_offerfileName, 's3');
            $student->unconditional_offer = $unconditional_offer;
       }

          
       if($request->file('payment_proof')) {

            $payment_prooffileName = uniqid('payment_proof' . '_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $payment_proof = $request->file('payment_proof')->storeAs('payment_proof_files', $payment_prooffileName, 's3');
            $student->payment_proof = $payment_proof;
       }





          
       if($request->file('cas_ecoe')) {

            $cas_ecoefileName = uniqid('cas_ecoe' . '_') . '.' .  $request->file('cas_ecoe')->getClientOriginalExtension();
            $cas_ecoe = $request->file('cas_ecoe')->storeAs('cas_ecoe_files', $cas_ecoefileName, 's3');
            $student->cas_ecoe = $cas_ecoe;
       }

          
       if($request->file('visa')) {

        $visafileName = uniqid('visa' . '_') . '.' . $request->file('visa')->getClientOriginalExtension();
        $visa = $request->file('visa')->storeAs('visa_files', $visafileName, 's3');
        $student->visa = $visa;
          

       }

          
       if($request->file('travel_plan')) {
            $travel_planfileName = uniqid('travel_plan' . '_') . '.' . $request->file('travel_plan')->getClientOriginalExtension();
            $travel_plan = $request->file('travel_plan')->storeAs('travel_plan_files', $travel_planfileName, 's3');
            $student->travel_plan = $travel_plan;
       }


       if($request->file('gt_document')) {
            $gt_documentfileName = uniqid('gt_document' . '_') . '.' . $request->file('gt_document')->getClientOriginalExtension();
            $gt_document = $request->file('gt_document')->storeAs('gt_document_files', $gt_documentfileName, 's3');
            $student->gt_document = $gt_document;
       }

        $student->save();
        return response()->json(['message' => 'Student record created successfully', 'data' => $student], 200);

    }

}
