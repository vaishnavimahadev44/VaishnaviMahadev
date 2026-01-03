<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class VisaType extends Model
{
    use HasFactory;
protected $table = 'visa_types';
   protected $fillable = [
       'id',
       'text',
       'value',
       'price'
    ];

    //Disable automatic created_at and updated_at
    public $timestamps = false;
}
             