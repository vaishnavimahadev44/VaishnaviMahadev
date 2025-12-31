<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class TemplateBuying extends Model
{
    use HasFactory;
protected $table = 'template_buying';
   protected $fillable = [
        'id',
        'template_name',
        'template_price',
        'description',
        'created_at'
    ];
}
             