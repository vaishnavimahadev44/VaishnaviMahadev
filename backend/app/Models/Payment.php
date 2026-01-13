<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    protected $table = 'payments';

    protected $fillable = [
        'application_id',
        'payment_method',
        'payment_status',
        'amount',
        'currency',
        'transaction_reference'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}