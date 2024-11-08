<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Stage;
use App\Models\Grade;

class Classroom extends Model
{
    use HasTranslations;

    protected $table = 'classrooms';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
        'stage_id',
        'grade_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function stage(){
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function grade(){
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    # Relation Many to many with teachers
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'classroom_teacher');
    }
}
