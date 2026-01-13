<?php

class ApplicationAudit extends Model
{
    protected $table = 'application_audit';
    protected $primaryKey = 'audit_id';

    protected $fillable = [
        'application_id',
        'step_number',
        'action',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}