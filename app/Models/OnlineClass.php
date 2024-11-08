<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OnlineClass extends Model
{
    use HasTranslations;

    protected $table = 'online_classes';

    public $translatable = ['topic'];

    protected $fillable = [
        'id',
        'integration',
        'stage_id',
        'grade_id',
        'classroom_id',
        'teacher_id',
        'meeting_id',
        'topic',
        'duration',
        'password',
        'start_time',
        'start_url',
        'join_url',
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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
