<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MyParent extends Model
{
    use HasTranslations;

    protected $table = 'parents';

    public $translatable = [
        'father_name',
        'father_job',
        'father_address',

        'mother_name',
        'mother_job',
        'mother_address',
    ];

    protected $fillable = [
        'id',
        'email',
        'password',
        'father_name',
        'father_national_id',
        'father_passport_id',
        'father_phone',
        'father_job',
        'father_nationality',
        'father_blood_type',
        'father_religion',
        'father_address',

        'mother_name',
        'mother_national_id',
        'mother_passport_id',
        'mother_phone',
        'mother_job',
        'mother_nationality',
        'mother_blood_type',
        'mother_religion',
        'mother_address',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function fatherNationality()
    {
        return $this->belongsTo(Nationality::class, 'father_nationality');
    }

    public function motherNationality()
    {
        return $this->belongsTo(Nationality::class, 'mother_nationality');
    }

    public function fatherBloodType()
    {
        return $this->belongsTo(Blood::class, 'father_blood_type');
    }

    public function motherBloodType()
    {
        return $this->belongsTo(Blood::class, 'mother_blood_type');
    }

    public function fatherReligion()
    {
        return $this->belongsTo(Religion::class, 'father_religion');
    }

    public function motherReligion()
    {
        return $this->belongsTo(Religion::class, 'mother_religion');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
