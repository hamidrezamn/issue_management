<?php
namespace App\models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permissions';
    public $fillable = ['name', 'display_name', 'description'];
        
    public function parent()
    {
        return $this->hasOne(Role::class, 'id');
    }
}