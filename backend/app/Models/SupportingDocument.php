<?php

class SupportingDocument extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'application_id',
        'applicant_type',
        'applicant_id',
        'document_type',
        'file_name',
        'file_path',
        'notes',
        'uploaded_at',
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }
}