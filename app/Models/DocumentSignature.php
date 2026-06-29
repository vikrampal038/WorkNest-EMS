<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSignature extends Model
{
    protected $fillable = [
        'document_id',
        'user_id',
        'signed_at',
        'ip_address',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
