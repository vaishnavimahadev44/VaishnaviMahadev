<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaDeadline extends Model
{
    protected $primaryKey = 'deadline_id';
    protected $table = 'visa_deadlines';

    protected $fillable = [
        'application_id',
        'deadline_date',
        'reason',
        'additional_details'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}