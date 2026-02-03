<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';
    protected $primaryKey = 'personal_info_id';

    protected $fillable = [
        'application_id',
        'full_name',
        'primary_phone',
        'alternate_phone',
        'email',
        'street_address',
        'city',
        'state',
        'postal_code',
        'gender',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}