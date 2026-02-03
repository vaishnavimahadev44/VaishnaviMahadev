<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EligibilityInfo extends Model
{
    protected $table = 'eligibility_info';
    protected $primaryKey = 'eligibility_id';

    protected $fillable = [
        'application_id',
        'email',
        'nationality',
        'date_of_birth',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}