<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class VisaTypes extends Model
{
    use HasFactory;
protected $table = 'visa_types';
   protected $fillable = [
        'id',
       'text',
       'value',
       'price'
    ];
}
             