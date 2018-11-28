<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AnswerQuestion extends Model
{
    protected $table = 'answer_question';

    public $timestamps = false;
    
    public function parent()
    {
        return $this->hasOne(AnswerQuestion::class, 'answer_id');
    }
}