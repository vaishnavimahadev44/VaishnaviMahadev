<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantContactDetail extends Model
{
    protected $primaryKey = 'contact_id';
    protected $table = 'applicant_contact_details';

    protected $fillable = [
        'application_id',
        'full_name',
        'email',
        'contact_number',
        'preferred_contact_time',
        'additional_notes'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}