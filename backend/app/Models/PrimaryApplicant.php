<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryApplicant extends Model
{
    protected $table = 'primary_applicant';
    protected $primaryKey = 'applicant_id';

    protected $fillable = [
        'application_id',
        'full_name',
        'email',
        'phone_number',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}