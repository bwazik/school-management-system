<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Stage extends Model
{
    use HasTranslations;

    protected $table = 'stages';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class, 'stage_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'stage_id');
    }
}
