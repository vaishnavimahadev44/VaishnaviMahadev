<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaDocument extends Model
{
    protected $table = 'visa_documents';
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'application_id',
        'applicant_type',
        'applicant_id',
        'document_type',
        'file_type',
        'file_data',
        'notes'
    ];

    public function application()
    {
        return $this->belongsTo(VisaApplication::class, 'application_id');
    }

    public function files()
    {
        return $this->hasMany(VisaDocumentFile::class, 'document_id');
    }

}