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
            if ($module->where('name', $module_code)) {
                if ($module->pivot->$access == true) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}
