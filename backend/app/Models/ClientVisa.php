<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ClientVisa extends Model
{
    use HasFactory;
protected $table = 'evisa';
   protected $fillable = [
        'id',
        'passport_no',
        'applicant_name',
        'country',
        'visa_type',
        'status'
    ];
}
             