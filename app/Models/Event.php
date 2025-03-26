<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasTranslations;

    protected $table = 'events';

    public $translatable = ['title'];

    protected $fillable = [
        'id',
        'title',
        'label',
        'start',
        'end',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
