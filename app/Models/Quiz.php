<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $table = 'quizzes';//имя табл
    protected  $fillable=[
        'quizId',
    ];

    //свззываем таблицы Отношения «многие-ко-многим» belongsToMany
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
