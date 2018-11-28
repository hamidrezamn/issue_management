<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions';
    public $fillable = ['title', 'body', 'attachement', 'status', 'user_id'];
        
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}