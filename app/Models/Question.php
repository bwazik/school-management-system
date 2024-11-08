<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations;

    protected $table = 'questions';

    public $translatable = ['question_text'];

    protected $fillable = [
        'id',
        'question_text',
        'degree',
        'quiz_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
