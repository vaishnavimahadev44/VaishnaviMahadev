<?php

class AdditionalTravelInfo extends Model
{
    protected $table = 'additional_travel_info';
    protected $primaryKey = 'id';

    protected $fillable = [
        'additional_applicant_id',
        'destination_country',
        'departure_date',
        'return_date',
        'purpose_of_travel',
        'accommodation_type',
        'accommodation_details',
    ];

    public function applicant()
    {
        return $this->belongsTo(AdditionalApplicant::class, 'additional_applicant_id');
    }
}