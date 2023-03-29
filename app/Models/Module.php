<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'module_permissions','module_id','permission_id');
    }

    public function modulePermissions()
    {
        return $this->hasMany(ModulePermission::class,'module_id');
    }

    public function hasAccess($module_name,$access_name)
    {
        foreach($this->modulePermissions as $modulePermission){
            if($modulePermission->$access_name){
                return true;
            };
        }
        
    }
}
