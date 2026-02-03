<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'session_id',
        'full_name',
        'email',
        'phone',
        'address',
        'purchase_intent',
    ];

    // Relationships
    public function responses()
    {
        return $this->hasMany(CustomerResponse::class, 'session_id', 'session_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(UploadedDocument::class, 'customer_id');
    }
}