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
}
