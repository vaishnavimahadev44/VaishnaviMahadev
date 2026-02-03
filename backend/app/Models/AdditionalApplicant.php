<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdditionalApplicant extends Model
{
    protected $table = 'additional_applicants';
    protected $primaryKey = 'additional_applicant_id';

    protected $fillable = [
        'application_id',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'nationality',
        'gender',
        'relationship',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }

    public function employmentInfo()
    {
        return $this->hasOne(AdditionalEmploymentInfo::class, 'additional_applicant_id');
    }

    public function travelInfo()
    {
        return $this->hasOne(AdditionalTravelInfo::class, 'additional_applicant_id');
    }
}