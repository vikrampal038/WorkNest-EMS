<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'category', 'file_path', 'size',
        'status', 'requires_signature', 'signature_path', 'expiry_date',
        'visibility', 'version', 'parent_document_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function signatures()
    {
        return $this->hasMany(DocumentSignature::class);
    }

    public function versions()
    {
        return $this->hasMany(Document::class, 'parent_document_id');
    }
}
