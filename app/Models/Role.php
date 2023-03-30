<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    public function hasAccess($module_code, $access)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->hasAccess($module_code, $access)) { // =>permission.php -> hasAccess()
                return true;
            }else{
                return false;
            }
        }
    }
}
