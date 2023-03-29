<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_permissions', 'permission_id', 'module_id')->withPivot(['list_access', 'create_access', 'view_access', 'update_access', 'delete_access']);
    }

    public function hasAccess($module_code, $access)
    {
        foreach ($this->modules as $module) {


            // $module->where('name', $module_code)->where($access, true)->first(); {
            //     return true;
            // }

            // return false;

            // if(strtolower($module->name) == strtolower($module_name)){
            //     if($module->hasAccess($module_name,$access_name)){
            //         return true;
            //     };
            // }

            // if(strtolower($module->name) == strtolower($module_code) && $module->pivot->$access == true){
            //     return true;
            // }
            // return false;
        }
    }
}
