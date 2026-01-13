<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageCreditOption extends Model
{
    protected $primaryKey = 'credit_id';
    protected $table = 'message_credit_options';

    protected $fillable = [
        'application_id',
        'credits',
        'price'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }

    public function applicationPackages()
    {
        return $this->hasMany(ApplicationPackage::class, 'credit_id');
    }
}