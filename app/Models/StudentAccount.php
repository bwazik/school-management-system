<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    protected $table = 'student_account';

    protected $fillable = [
        'id',
        'type',
        'student_id',
        'invoice_id',
        'receipt_id',
        'payment_id',
        'refund_id',
        'debit',
        'credit',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
