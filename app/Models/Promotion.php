<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'id',
        'student_id',
        'from_stage',
        'from_grade',
        'from_classroom',
        'from_academic_year',
        'to_stage',
        'to_grade',
        'to_classroom',
        'to_academic_year',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function f_stage()
    {
        return $this->belongsTo(Stage::class, 'from_stage');
    }

    public function f_grade()
    {
        return $this->belongsTo(Grade::class, 'from_grade');
    }

    public function f_classroom()
    {
        return $this->belongsTo(Classroom::class, 'from_classroom');
    }

    public function t_stage()
    {
        return $this->belongsTo(Stage::class, 'to_stage');
    }

    public function t_grade()
    {
        return $this->belongsTo(Grade::class, 'to_grade');
    }

    public function t_classroom()
    {
        return $this->belongsTo(Classroom::class, 'to_classroom');
    }
}
