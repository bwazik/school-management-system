<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;
use App\Models\Subject;
use App\Models\Gender;
use App\Models\Classroom;

class Teacher extends Authenticatable
{
    use HasTranslations;

    protected $table = 'teachers';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'email',
        'password',
        'name',
        'subject_id',
        'gender_id',
        'joining_date',
        'address',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    # Relation Many to many with sections
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teacher');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
