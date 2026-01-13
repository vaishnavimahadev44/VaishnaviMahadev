<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaPreviousIssue extends Model
{
    protected $primaryKey = 'issue_id';
    protected $table = 'visa_previous_issues';

    protected $fillable = [
        'application_id',
        'issue_type',
        'issue_date',
        'country',
        'description',
        'resolution_status'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}