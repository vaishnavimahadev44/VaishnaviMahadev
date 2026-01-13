<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationPackage extends Model
{
    protected $primaryKey = 'app_package_id';
    protected $table = 'application_packages';

    protected $fillable = [
        'application_id',
        'package_id',
        'credit_id',
        'total_price'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }

    public function package()
    {
        return $this->belongsTo(VisaPackage::class, 'package_id');
    }

    public function creditOption()
    {
        return $this->belongsTo(MessageCreditOption::class, 'credit_id');
    }
}