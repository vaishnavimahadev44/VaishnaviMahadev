<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TravelInfo extends Model
{
    protected $table = 'travel_info';
    protected $primaryKey = 'travel_id';

    protected $fillable = [
        'application_id',
        'destination_country',
        'departure_date',
        'return_date',
        'purpose_of_travel',
        'accommodation_details',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}