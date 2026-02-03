<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaDocumentFile extends Model
{
    protected $table = 'visa_document_files';
    protected $primaryKey = 'file_id';
    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'file_name',
        'file_type',
        'file_data',
        'uploaded_at',
    ];

    // Hide binary column from JSON responses
    protected $hidden = ['file_data'];


    public function document()
    {
        return $this->belongsTo(VisaDocument::class, 'document_id');
    }
}