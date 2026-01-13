<?php

class EmploymentInfo extends Model
{
    protected $table = 'employment_info';
    protected $primaryKey = 'employment_id';

    protected $fillable = [
        'application_id',
        'employer',
        'job_title',
        'work_address',
        'work_phone',
        'years_at_job',
        'employment_status',
        'annual_income',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}