<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerResponse extends Model
{
    protected $primaryKey = 'response_id';

    protected $fillable = [
        'session_id',
        'step_number',
        'question_text',
        'option_text',
        'response_text',
    ];

    // Link back to customer via session_id
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'session_id', 'session_id');
    }
}