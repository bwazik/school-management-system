<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'students';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'stage_id',
        'grade_id',
        'classroom_id',
        'parent_id',
        'academic_year',
        'gender_id',
        'nationality',
        'blood_type',
        'religion',
        'birthday',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function myParent()
    {
        return $this->belongsTo(MyParent::class, 'parent_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function myNationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality');
    }

    public function blood()
    {
        return $this->belongsTo(Blood::class, 'blood_type');
    }

    public function myReligion()
    {
        return $this->belongsTo(Religion::class, 'religion');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
