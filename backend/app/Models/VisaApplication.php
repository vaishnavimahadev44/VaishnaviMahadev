<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    protected $primaryKey = 'application_id';
    protected $table = 'visa_applications';

    protected $fillable = [
        'visa_country',
        'visa_type',
        'has_dependents',
        'has_deadline',
        'has_previous_issues',
        'has_previous_uk_visa',
        'has_sponsor',
        'has_selected_recommended_package',
        'application_status'
    ];

    protected $casts = [
        'has_dependents' => 'boolean',
        'has_deadline' => 'boolean',
        'has_previous_issues' => 'boolean',
        'has_previous_uk_visa' => 'boolean',
        'has_sponsor' => 'boolean',
        'has_selected_recommended_package' => 'boolean',
    ];


    // Relationships
    public function dependents()
    {
        return $this->hasMany(VisaDependent::class, 'application_id');
    }

    public function deadline()
    {
        return $this->hasOne(VisaDeadline::class, 'application_id');
    }

    public function previousIssue()
    {
        return $this->hasOne(VisaPreviousIssue::class, 'application_id');
    }

    public function previousUkVisa()
    {
        return $this->hasOne(VisaPreviousUkVisa::class, 'application_id');
    }

    public function sponsor()
    {
        return $this->hasOne(VisaSponsor::class, 'application_id');
    }

    public function package()
    {
        return $this->hasone(VisaPackage::class, 'application_id');
    }

    public function messageCredits()
    {
        return $this->hasMany(MessageCreditOption::class, 'application_id');
    }

    public function applicationPackages()
    {
        return $this->hasMany(ApplicationPackage::class, 'application_id');
    }

    public function contactDetail()
    {
        return $this->hasOne(ApplicantContactDetail::class, 'application_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'application_id');
    }

    public function primaryApplicant()
    {
        return $this->hasOne(PrimaryApplicant::class, 'application_id');
    }

    public function eligibilityInfo()
    {
        return $this->hasOne(EligibilityInfo::class, 'application_id');
    }

    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class, 'application_id');
    }

    public function employmentInfo()
    {
        return $this->hasOne(EmploymentInfo::class, 'application_id');
    }

    public function travelInfo()
    {
        return $this->hasOne(TravelInfo::class, 'application_id');
    }

    public function additionalApplicants()
    {
        return $this->hasMany(AdditionalApplicant::class, 'application_id');
    }

    public function documents()
    {
        return $this->hasMany(VisaDocument::class, 'application_id');
    }
}