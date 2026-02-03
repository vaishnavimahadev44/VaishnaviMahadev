<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdditionalEmploymentInfo extends Model
{
    protected $table = 'additional_employment_info';
    protected $primaryKey = 'id';

    protected $fillable = [
        'additional_applicant_id',
        'employer',
        'job_title',
        'work_address',
        'work_phone',
        'years_at_job',
        'employment_status',
        'annual_income_range',
        'exact_annual_income',
        'education_level',
        'english_proficiency'
    ];

    public function additionalApplicant()
    {
        return $this->belongsTo(AdditionalApplicant::class, 'application_id');
    }
}