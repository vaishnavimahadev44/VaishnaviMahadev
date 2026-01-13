<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaSponsor extends Model
{
    protected $primaryKey = 'sponsor_id';
    protected $table = 'visa_sponsors';

    protected $fillable = [
        'application_id',
        'sponsor_type',
        'sponsor_name',
        'sponsor_email',
        'sponsor_phone',
        'sponsor_address',
        'sponsor_details'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}