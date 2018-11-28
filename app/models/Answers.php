<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $table = 'answers';
//    public $timestamps = false;
    public $fillable = ['body'];
        
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}