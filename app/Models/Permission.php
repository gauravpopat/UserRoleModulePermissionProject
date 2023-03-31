<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsToMany(Module::class, 'module_permissions', 'permission_id', 'module_id')->withPivot(['list_access', 'create_access', 'show_access', 'update_access', 'delete_access']);
    }

    public function hasAccess($module_code, $access)
    {
        foreach ($this->modules as $module) {
            $getModule = $module->where('name', $module_code)->first();
            if ($getModule) {
                $getAccess =  $module->pivot->where('module_id', $getModule->id)->where('permission_id', $this->id)->where($access, true)->first();
                if ($getAccess) {
                    return true;
                }
            }
        }
        return false;
    }
}
