<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';

    protected $fillable = ['user_id', 'photo_path', 'full_name', 'email', 'nationality', 'marital_status', 'gender', 'date_of_birth', 'place_of_birth', 'passport_no', 'expiry_date', 'place_of_issue', 'address', 'phone', 'mobile', 'mobile_2', 'referee_name', 'referee_mobile', 'document_correction', 'education_history', 'semester_year', 'country_detail', 'cv_path', 'passport','english_test','academic_document','teacher_reference','cnic','experience_letter', 'other_certificates', 'conditional_offer', 'payment_proof', 'cas_ecoe', 'visa', 'travel_plan', 'gt_document'];

    protected $hidden = ['user_id', 'updated_at'];
    

    protected $casts = [
        'education_history' => 'array',
        'country_detail' => 'array',
        'english_test' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
