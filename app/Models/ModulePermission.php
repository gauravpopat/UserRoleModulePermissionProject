<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'module_id',
        'view_access',
        'create_access',
        'update_access',
        'delete_access',
        'list_access'
    ];
}
