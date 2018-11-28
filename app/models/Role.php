<?php
namespace App\models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';
//    public $timestamps = false;
    public $fillable = ['name', 'display_name', 'description'];
    
    public function parent()
    {
	    return $this->hasOne(Role::class, 'id');
    }
}