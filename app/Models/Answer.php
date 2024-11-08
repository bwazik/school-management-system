<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Answer extends Model
{
    use HasTranslations;

    protected $table = 'answers';

    public $translatable = ['answer_text'];

    protected $fillable = [
        'id',
        'answer_text',
        'is_correct',
        'question_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
