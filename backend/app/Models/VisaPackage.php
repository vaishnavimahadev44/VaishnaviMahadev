<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaPackage extends Model
{
    protected $primaryKey = 'package_id';
    protected $table = 'visa_packages';

    protected $fillable = [
        'application_id',
        'package_name',
        'visa_type',
        'base_price'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
    
    public function applicationPackages()
    {
        return $this->hasMany(ApplicationPackage::class, 'package_id');
    }
}