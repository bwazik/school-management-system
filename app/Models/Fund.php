<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';

    protected $fillable = [
        'id',
        'date',
        'receipt_id',
        'payment_id',
        'debit',
        'credit',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_id');
    }
}
