<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaPreviousUkVisa extends Model
{
    protected $primaryKey = 'previous_visa_id';
    protected $table = 'visa_previous_uk_visas';

    protected $fillable = [
        'application_id',
        'visa_type',
        'issue_date',
        'expiry_date',
        'visa_number',
        'purpose_of_visit',
        'issues'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}