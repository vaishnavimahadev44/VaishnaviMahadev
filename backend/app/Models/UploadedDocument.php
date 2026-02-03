<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    protected $primaryKey = 'doc_id';

    protected $fillable = [
        'customer_id',
        'file_name',
        'file_type',
        'file_data',
    ];

    // Hide binary column from JSON responses
    protected $hidden = ['file_data'];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}