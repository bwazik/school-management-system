<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    protected $table = 'settings';

    public $translatable = ['school_name', 'school_address'];

    protected $fillable = [
        'school_title',
        'school_name',
        'school_address',
        'school_phone',
        'school_email',
        'school_logo',
        'default_language',
        'timezone',
        'academic_year_start',
        'academic_year_end',
        'max_students_per_class',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
