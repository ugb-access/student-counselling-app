<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Aws\S3\S3Client;
class StudentController extends Controller
{
    public function get_student_detail(Request $request, $id) {
        $student_id = $id;
        $user = $request->user();
        $s3_url = env('AWS_URL');
        
        if($user && !empty($user)) {
            if($user->role_id === 1) {
                $student_data = User::with('student')->find($student_id);
                
                
                if(!$student_data->student) {
                    return response()->json(['data' => $student_data], 200);
                }
                //required
                if($student_data->student->photo_path) {
                    $student_data->student->photo_path = $s3_url . '/' . $student_data->student->photo_path;
                }

                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . '/' . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . '/' . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . '/' . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . '/' . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . '/' . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . '/' . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . '/' . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . '/' . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . '/' . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . '/' . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . '/' . $student_data->student->cas_ecoe;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . '/' . $student_data->student->visa;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . '/' . $student_data->student->travel_plan;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . '/' . $student_data->student->gt_document;

                }

                $english_test_urls = [];
                if($student_data->student->english_test) {
                    foreach ($student_data->student->english_test as $key => $value) {
                        $english_test_urls[$key] =  $s3_url . '/' . $value;
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
                $student_data->student->photo_path = $s3_url . '/' . $student_data->student->photo_path;
                
                
                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . '/' . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . '/' . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . '/' . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . '/' . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . '/' . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . '/' . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . '/' . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . '/' . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . '/' . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . '/' . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . '/' . $student_data->student->payment_proof;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . '/' . $student_data->student->payment_proof;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . '/' . $student_data->student->payment_proof;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . '/' . $student_data->student->payment_proof;

                }


               

               
                $english_test_urls = [];
                if($student_data->student->english_test) {
                    foreach ($student_data->student->english_test as $key => $value) {
                        $english_test_urls[$key] =  $s3_url . '/' . $value;
                    }
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
                $student_data->student->photo_path = $s3_url . '/' . $student_data->student->photo_path;

                //optional
               
                if($student_data->student->cv_path) {
                    $student_data->student->cv_path = $s3_url . '/' . $student_data->student->cv_path;

                }
                if($student_data->student->passport) {
                    $student_data->student->passport = $s3_url . '/' . $student_data->student->passport;
                }
                
                if($student_data->student->academic_document) {
                $student_data->student->academic_document = $s3_url . '/' . $student_data->student->academic_document;

                }


                if($student_data->student->teacher_reference) {
                    $student_data->student->teacher_reference = $s3_url . '/' . $student_data->student->teacher_reference;

                }

                if($student_data->student->cnic) {
                    $student_data->student->cnic = $s3_url . '/' . $student_data->student->cnic;

                }

                if($student_data->student->experience_letter) {
                    $student_data->student->experience_letter = $s3_url . '/' . $student_data->student->experience_letter;

                }

                if($student_data->student->other_certificates) {
                    $student_data->student->other_certificates = $s3_url . '/' . $student_data->student->other_certificates;

                }

                if($student_data->student->conditional_offer) {
                    $student_data->student->conditional_offer = $s3_url . '/' . $student_data->student->conditional_offer;

                }

                if($student_data->student->unconditional_offer) {
                    $student_data->student->unconditional_offer = $s3_url . '/' . $student_data->student->unconditional_offer;

                }

                if($student_data->student->payment_proof) {
                    $student_data->student->payment_proof = $s3_url . '/' . $student_data->student->payment_proof;

                }


                if($student_data->student->cas_ecoe) {
                    $student_data->student->cas_ecoe = $s3_url . '/' . $student_data->student->payment_proof;

                }

                if($student_data->student->visa) {
                    $student_data->student->visa = $s3_url . '/' . $student_data->student->payment_proof;

                }


                if($student_data->student->travel_plan) {
                    $student_data->student->travel_plan = $s3_url . '/' . $student_data->student->payment_proof;

                }
                if($student_data->student->gt_document) {
                    $student_data->student->gt_document = $s3_url . '/' . $student_data->student->payment_proof;

                }


               

               
                $english_test_urls = [];
                if($student_data->student->english_test) {
                    foreach ($student_data->student->english_test as $key => $value) {
                        $english_test_urls[$key] =  $s3_url . '/' . $value;
                    }
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

        $data = $request->all();

        // Initialize an AWS S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Specify the S3 bucket and object key
        $bucket = env('AWS_BUCKET');
        
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
            'mobile_2' => 'nullable|string|max:35',
            'referee_name' => 'nullable|string',
            'referee_mobile' => 'nullable|string|max:35',
            'document_correction' => 'nullable|string|max:255',
            // 'education_history' => 'required|array', 
            'semester_year' => 'required|integer|in:1,2,3,4',
            // 'country_detail' => 'required|array',


            'cv_path' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'passport' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000', 
            'english_test.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'academic_document' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'teacher_reference' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'cnic' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'experience_letter' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'other_certificates' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000', 
            'conditional_offer' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'unconditional_offer' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'payment_proof' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'cas_ecoe' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'visa' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'travel_plan' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'gt_document' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',


        ]);

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
        
        $uploaded_file_count = 0;

        if($request->file('cv_path')) {
            $cvfileName = uniqid('cv' . '_') . '.' . $request->file('cv_path')->getClientOriginalExtension();
            $cv_path = $request->file('cv_path')->storeAs('cv_files', $cvfileName, 's3');
            $student->cv_path = $cv_path;
            $uploaded_file_count++;
             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $cvfileName . '"';

            
             $objectKey = $cv_path;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('cv_path')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('cv_path')->getRealPath(),
             ]);
        } 

        if($request->file('passport')) {
            $passportfileName = uniqid('passport' . '_') . '.' . $request->file('passport')->getClientOriginalExtension();
            $passport = $request->file('passport')->storeAs('passport_files', $passportfileName, 's3');
            $student->passport = $passport;
            $uploaded_file_count++;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $passportfileName . '"';

        
             $objectKey = $passport;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('passport')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('passport')->getRealPath(),
             ]);
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



                 // Set the desired Content-Disposition header
                 $contentDisposition = 'attachment; filename="' . $fileName . '"';

            
                 $objectKey = $filePath;
 
                 // Set the Content-Disposition header using the AWS SDK
                 $s3Client->putObject([
                     'Bucket' => $bucket,
                     'Key' => $objectKey,
                     'ContentType' => $file->getMimeType(),
                     'ContentDisposition' => $contentDisposition,
                     'SourceFile' => $file->getRealPath(),
                 ]);
            }
    
           
            $student->english_test = $englishTestPaths;
            $uploaded_file_count++;
        }
        
       if($request->file('academic_document')) {
            $academic_documentfileName = uniqid('academic_document' . '_') . '.' . $request->file('academic_document')->getClientOriginalExtension();
            $academic_document = $request->file('academic_document')->storeAs('academic_document_files', $academic_documentfileName, 's3');
            $student->academic_document = $academic_document;
            $uploaded_file_count++;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $academic_documentfileName . '"';

        
             $objectKey = $academic_document;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('academic_document')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('academic_document')->getRealPath(),
             ]);
       }


          
       if($request->file('cnic')) {
            $cnicfileName = uniqid('cnic' . '_') . '.' . $request->file('cnic')->getClientOriginalExtension();
            $cnic = $request->file('cnic')->storeAs('cnic_files', $cnicfileName, 's3');
            $student->cnic = $cnic;
            $uploaded_file_count++;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $cnicfileName . '"';

        
             $objectKey = $cnic;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('cnic')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('cnic')->getRealPath(),
             ]);
       }


          
       if($request->file('teacher_reference')) {

            $teacher_referencefileName = uniqid('teacher_reference' . '_') . '.' . $request->file('teacher_reference')->getClientOriginalExtension();
            $teacher_reference = $request->file('teacher_reference')->storeAs('teacher_reference_files', $teacher_referencefileName, 's3');
            $student->teacher_reference = $teacher_reference;
            $uploaded_file_count++;

              // Set the desired Content-Disposition header
              $contentDisposition = 'attachment; filename="' . $teacher_referencefileName . '"';

        
              $objectKey = $teacher_reference;
  
              // Set the Content-Disposition header using the AWS SDK
              $s3Client->putObject([
                  'Bucket' => $bucket,
                  'Key' => $objectKey,
                  'ContentType' => $request->file('teacher_reference')->getMimeType(),
                  'ContentDisposition' => $contentDisposition,
                  'SourceFile' => $request->file('teacher_reference')->getRealPath(),
              ]);
       }

          
       if($request->file('experience_letter')) {

            $experience_letterfileName = uniqid('experience_letter' . '_') . '.' . $request->file('experience_letter')->getClientOriginalExtension();
            $experience_letter = $request->file('experience_letter')->storeAs('experience_letter_files', $experience_letterfileName, 's3');
            $student->experience_letter = $experience_letter;
            $uploaded_file_count++;



            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $experience_letterfileName . '"';

        
            $objectKey = $experience_letter;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('experience_letter')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('experience_letter')->getRealPath(),
            ]);
       }



          
       if($request->file('other_certificates')) {
            $other_certificatesfileName = uniqid('other_certificates' . '_') . '.' . $request->file('other_certificates')->getClientOriginalExtension();
            $other_certificates = $request->file('other_certificates')->storeAs('other_certificates_files', $other_certificatesfileName, 's3');
            $student->other_certificates = $other_certificates;
            $uploaded_file_count++;


             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $other_certificatesfileName . '"';

        
             $objectKey = $other_certificates;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('other_certificates')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('other_certificates')->getRealPath(),
             ]);
       }

       if($request->file('conditional_offer')) {
            $conditional_offerfileName = uniqid('conditional_offer' . '_') . '.' . $request->file('conditional_offer')->getClientOriginalExtension();
            $conditional_offer = $request->file('conditional_offer')->storeAs('conditional_offer_files', $conditional_offerfileName, 's3');
            $student->conditional_offer = $conditional_offer;
            $uploaded_file_count++;



            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $conditional_offerfileName . '"';

        
            $objectKey = $conditional_offer;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('conditional_offer')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('conditional_offer')->getRealPath(),
            ]);
       }


          
       if($request->file('unconditional_offer')) {
            $unconditional_offerfileName = uniqid('unconditional_offer' . '_') . '.' . $request->file('unconditional_offer')->getClientOriginalExtension();
            $unconditional_offer = $request->file('unconditional_offer')->storeAs('unconditional_offer_files', $unconditional_offerfileName, 's3');
            $student->unconditional_offer = $unconditional_offer;
            $uploaded_file_count++;



             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $unconditional_offerfileName . '"';

        
             $objectKey = $unconditional_offer;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('unconditional_offer')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('unconditional_offer')->getRealPath(),
             ]);
       }

          
       if($request->file('payment_proof')) {

            $payment_prooffileName = uniqid('payment_proof' . '_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $payment_proof = $request->file('payment_proof')->storeAs('payment_proof_files', $payment_prooffileName, 's3');
            $student->payment_proof = $payment_proof;
            $student->payment_status = 1;
            $uploaded_file_count++;



            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $payment_prooffileName . '"';

        
            $objectKey = $payment_proof;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('payment_proof')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('payment_proof')->getRealPath(),
            ]);
       }

      
          
       if($request->file('cas_ecoe')) {

            $cas_ecoefileName = uniqid('cas_ecoe' . '_') . '.' .  $request->file('cas_ecoe')->getClientOriginalExtension();
            $cas_ecoe = $request->file('cas_ecoe')->storeAs('cas_ecoe_files', $cas_ecoefileName, 's3');
            $student->cas_ecoe = $cas_ecoe;
            $uploaded_file_count++;


             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $cas_ecoefileName . '"';

        
             $objectKey = $cas_ecoe;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('cas_ecoe')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('cas_ecoe')->getRealPath(),
             ]);
       }

          
       if($request->file('visa')) {

            $visafileName = uniqid('visa' . '_') . '.' . $request->file('visa')->getClientOriginalExtension();
            $visa = $request->file('visa')->storeAs('visa_files', $visafileName, 's3');
            $student->visa = $visa;
            $uploaded_file_count++;                                             
          
            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $visafileName . '"';

        
            $objectKey = $visa;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('visa')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('visa')->getRealPath(),
            ]);

       }

          
       if($request->file('travel_plan')) {
            $travel_planfileName = uniqid('travel_plan' . '_') . '.' . $request->file('travel_plan')->getClientOriginalExtension();
            $travel_plan = $request->file('travel_plan')->storeAs('travel_plan_files', $travel_planfileName, 's3');
            $student->travel_plan = $travel_plan;
            $uploaded_file_count++; 

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $travel_planfileName . '"';

        
             $objectKey = $travel_plan;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('travel_plan')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('travel_plan')->getRealPath(),
             ]);
       }


       if($request->file('gt_document')) {
            $gt_documentfileName = uniqid('gt_document' . '_') . '.' . $request->file('gt_document')->getClientOriginalExtension();
            $gt_document = $request->file('gt_document')->storeAs('gt_document_files', $gt_documentfileName, 's3');
            $student->gt_document = $gt_document;
            $uploaded_file_count++; 

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $gt_documentfileName . '"';

        
            $objectKey = $gt_document;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('gt_document')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('gt_document')->getRealPath(),
            ]);
       }


       if($uploaded_file_count === 15) {
            $student->status = 1;
       }


        $student->save();
        return response()->json(['message' => 'Student record created successfully', 'data' => $student], 200);
    }




    public function update_student_detail(Request $request, Student $student) {
        $data = $request->all();
        // Initialize an AWS S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Specify the S3 bucket and object key
        $bucket = env('AWS_BUCKET');
        
        $validator = Validator::make($data, [

            'photo_path' => 'image|max:2048',
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
            'referee_name' => 'nullable|string',
            'referee_mobile' => 'nullable|string|max:35',
            'document_correction' => 'nullable|string|max:255',
            // 'education_history' => 'array', 
            'semester_year' => 'integer|in:1,2,3,4',
            // 'country_detail' => 'array',


            'cv_path' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'passport' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000', 
            'english_test.*' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'academic_document' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'teacher_reference' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'cnic' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'experience_letter' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'other_certificates' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000', 
            'conditional_offer' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'unconditional_offer' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'payment_proof' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'cas_ecoe' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'visa' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'travel_plan' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',
            'gt_document' => 'nullable|mimes:pdf,doc,docx,jpeg,png,jpg|max:5000',


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




        if($request->input('address') && !empty($request->input('address'))) {
            $student->address = $request->input('address');
        }

        if($request->input('mobile') && !empty($request->input('mobile'))) {
            $student->mobile = $request->input('mobile');
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

        if($request->has('place_of_issue')) {
            $student->place_of_issue = $request->input('place_of_issue');
        }
        if($request->has('mobile_2') ) {
            $student->mobile_2 = $request->input('mobile_2');
        }

        if($request->has('referee_name') ) {
            $student->referee_name = $request->input('referee_name');
        }

        if($request->has('referee_mobile') ) {
            $student->referee_mobile = $request->input('referee_mobile');
        }

        if($request->has('document_correction') ) {
            $student->document_correction = $request->input('document_correction');
        }
        
        if($request->file('cv_path')) {
            $cvfileName = uniqid('cv' . '_') . '.' . $request->file('cv_path')->getClientOriginalExtension();
            $cv_path = $request->file('cv_path')->storeAs('cv_files', $cvfileName, 's3');
            $student->cv_path = $cv_path;
           
            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $cvfileName . '"';

            
            $objectKey = $cv_path;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('cv_path')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('cv_path')->getRealPath(),
            ]);

           
        }
            

        if($request->file('passport')) {
            $passportfileName = uniqid('passport' . '_') . '.' . $request->file('passport')->getClientOriginalExtension();
            $passport = $request->file('passport')->storeAs('passport_files', $passportfileName, 's3');
            $student->passport = $passport;
             // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $passportfileName . '"';

        
            $objectKey = $passport;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('passport')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('passport')->getRealPath(),
            ]);
        }


        if($request->file('english_test') && count($request->file('english_test')) > 0) {
            $englishTestFiles = $request->file('english_test');
             
            // Initialize an array to store file paths
            $englishTestPaths = $student->english_test;
            // dd($englishTestFiles, $englishTestPaths);
            // Loop through each file in the array and store them
            foreach ($englishTestFiles as $key => $file) {
                // Generate a unique name for each file to avoid filename collisions
                $fileName = uniqid($key . '_') . '.' . $file->getClientOriginalExtension();
    
                // Store the file in the desired location (e.g., 'english_test_files' folder within the 's3' disk)
                $filePath = $file->storeAs('english_test_files', $fileName, 's3');

                // Set the desired Content-Disposition header
                $contentDisposition = 'attachment; filename="' . $fileName . '"';

            
                $objectKey = $filePath;

                // Set the Content-Disposition header using the AWS SDK
                $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key' => $objectKey,
                    'ContentType' => $file->getMimeType(),
                    'ContentDisposition' => $contentDisposition,
                    'SourceFile' => $file->getRealPath(),
                ]);
    
                // Add the file path to the array
                $englishTestPaths[$key] = $filePath;
            }
    
           
            $student->english_test = $englishTestPaths;
        }
        
       if($request->file('academic_document')) {
            $academic_documentfileName = uniqid('academic_document' . '_') . '.' . $request->file('academic_document')->getClientOriginalExtension();
            $academic_document = $request->file('academic_document')->storeAs('academic_document_files', $academic_documentfileName, 's3');
            $student->academic_document = $academic_document;


             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $academic_documentfileName . '"';

        
             $objectKey = $academic_document;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('academic_document')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('academic_document')->getRealPath(),
             ]);
       }


          
       if($request->file('cnic')) {
            $cnicfileName = uniqid('cnic' . '_') . '.' . $request->file('cnic')->getClientOriginalExtension();
            $cnic = $request->file('cnic')->storeAs('cnic_files', $cnicfileName, 's3');
            $student->cnic = $cnic;


             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $cnicfileName . '"';

        
             $objectKey = $cnic;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('cnic')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('cnic')->getRealPath(),
             ]);
       }


          
       if($request->file('teacher_reference')) {

            $teacher_referencefileName = uniqid('teacher_reference' . '_') . '.' . $request->file('teacher_reference')->getClientOriginalExtension();
            $teacher_reference = $request->file('teacher_reference')->storeAs('teacher_reference_files', $teacher_referencefileName, 's3');
            $student->teacher_reference = $teacher_reference;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $teacher_referencefileName . '"';

        
            $objectKey = $teacher_reference;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('teacher_reference')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('teacher_reference')->getRealPath(),
            ]);
       }

          
       if($request->file('experience_letter')) {

            $experience_letterfileName = uniqid('experience_letter' . '_') . '.' . $request->file('experience_letter')->getClientOriginalExtension();
            $experience_letter = $request->file('experience_letter')->storeAs('experience_letter_files', $experience_letterfileName, 's3');
            $student->experience_letter = $experience_letter;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $experience_letterfileName . '"';

        
             $objectKey = $experience_letter;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('experience_letter')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('experience_letter')->getRealPath(),
             ]);
       }



          
       if($request->file('other_certificates')) {
            $other_certificatesfileName = uniqid('other_certificates' . '_') . '.' . $request->file('other_certificates')->getClientOriginalExtension();
            $other_certificates = $request->file('other_certificates')->storeAs('other_certificates_files', $other_certificatesfileName, 's3');
            $student->other_certificates = $other_certificates;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $other_certificatesfileName . '"';

        
            $objectKey = $other_certificates;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('other_certificates')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('other_certificates')->getRealPath(),
            ]);
       }


       


          
       if($request->file('conditional_offer')) {
            $conditional_offerfileName = uniqid('conditional_offer' . '_') . '.' . $request->file('conditional_offer')->getClientOriginalExtension();
            $conditional_offer = $request->file('conditional_offer')->storeAs('conditional_offer_files', $conditional_offerfileName, 's3');
            $student->conditional_offer = $conditional_offer;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $conditional_offerfileName . '"';

        
            $objectKey = $conditional_offer;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('conditional_offer')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('conditional_offer')->getRealPath(),
            ]);
       }


          
       if($request->file('unconditional_offer')) {
            $unconditional_offerfileName = uniqid('unconditional_offer' . '_') . '.' . $request->file('unconditional_offer')->getClientOriginalExtension();
            $unconditional_offer = $request->file('unconditional_offer')->storeAs('unconditional_offer_files', $unconditional_offerfileName, 's3');
            $student->unconditional_offer = $unconditional_offer;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $unconditional_offerfileName . '"';

        
             $objectKey = $unconditional_offer;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('unconditional_offer')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('unconditional_offer')->getRealPath(),
             ]);
       }

          
       if($request->file('payment_proof')) {

            $payment_profileName = uniqid('payment_proof' . '_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
            $payment_proof = $request->file('payment_proof')->storeAs('payment_proof_files', $payment_profileName, 's3');
            $student->payment_proof = $payment_proof;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $payment_profileName . '"';

        
            $objectKey = $payment_proof;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('payment_proof')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('payment_proof')->getRealPath(),
            ]);

            if(!$student->payment_status) {
                $student->payment_status = 1;
            }
       }





          
       if($request->file('cas_ecoe')) {

            $cas_ecoefileName = uniqid('cas_ecoe' . '_') . '.' .  $request->file('cas_ecoe')->getClientOriginalExtension();
            $cas_ecoe = $request->file('cas_ecoe')->storeAs('cas_ecoe_files', $cas_ecoefileName, 's3');
            $student->cas_ecoe = $cas_ecoe;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $cas_ecoefileName . '"';

        
            $objectKey = $cas_ecoe;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('cas_ecoe')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('cas_ecoe')->getRealPath(),
            ]);
       }

          
       if($request->file('visa')) {

            $visafileName = uniqid('visa' . '_') . '.' . $request->file('visa')->getClientOriginalExtension();
            $visa = $request->file('visa')->storeAs('visa_files', $visafileName, 's3');
            $student->visa = $visa;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $visafileName . '"';

        
             $objectKey = $visa;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('visa')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('visa')->getRealPath(),
             ]);
          

       }

          
       if($request->file('travel_plan')) {
            $travel_planfileName = uniqid('travel_plan' . '_') . '.' . $request->file('travel_plan')->getClientOriginalExtension();
            $travel_plan = $request->file('travel_plan')->storeAs('travel_plan_files', $travel_planfileName, 's3');
            $student->travel_plan = $travel_plan;

             // Set the desired Content-Disposition header
             $contentDisposition = 'attachment; filename="' . $travel_planfileName . '"';

        
             $objectKey = $travel_plan;
 
             // Set the Content-Disposition header using the AWS SDK
             $s3Client->putObject([
                 'Bucket' => $bucket,
                 'Key' => $objectKey,
                 'ContentType' => $request->file('travel_plan')->getMimeType(),
                 'ContentDisposition' => $contentDisposition,
                 'SourceFile' => $request->file('travel_plan')->getRealPath(),
             ]);
       }


       if($request->file('gt_document')) {
            $gt_documentfileName = uniqid('gt_document' . '_') . '.' . $request->file('gt_document')->getClientOriginalExtension();
            $gt_document = $request->file('gt_document')->storeAs('gt_document_files', $gt_documentfileName, 's3');
            $student->gt_document = $gt_document;

            // Set the desired Content-Disposition header
            $contentDisposition = 'attachment; filename="' . $gt_documentfileName . '"';

        
            $objectKey = $gt_document;

            // Set the Content-Disposition header using the AWS SDK
            $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $objectKey,
                'ContentType' => $request->file('gt_document')->getMimeType(),
                'ContentDisposition' => $contentDisposition,
                'SourceFile' => $request->file('gt_document')->getRealPath(),
            ]);
       }

       if($student->gt_document && $student->travel_plan && $student->visa && $student->cas_ecoe && $student->payment_proof && $student->unconditional_offer && $student->conditional_offer && $student->other_certificates && $student->experience_letter && $student->teacher_reference && $student->cnic && $student->academic_document && $student->english_test && $student->passport && $student->cv_path) {
            $student->status = 1;
       }


        $student->save();
        return response()->json(['message' => 'Student record created successfully', 'data' => $student], 200);

    }


    

}
