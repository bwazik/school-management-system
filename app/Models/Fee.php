<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fee extends Model
{
    use HasTranslations;

    protected $table = 'fees';

    public $translatable = ['name'];

    protected $fillable = [
        'id',
        'name',
        'amount',
        'stage_id',
        'grade_id',
        'year',
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

}
