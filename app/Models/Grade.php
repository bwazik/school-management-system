<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Stage;

class Grade extends Model
{
    use HasTranslations;

    protected $table = 'grades';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
        'stage_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function stage(){
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'grade_id');
    }
}
