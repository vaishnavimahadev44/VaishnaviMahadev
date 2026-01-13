<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaDependent extends Model
{
    protected $primaryKey = 'dependent_id';
    protected $table = 'visa_dependents';

    protected $fillable = [
        'application_id',
        'full_name',
        'relationship',
        'date_of_birth',
        'nationality',
        'passport_number'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}