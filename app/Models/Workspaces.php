<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspaces extends Model
{
    protected $table = 'workspaces';

    protected $fillable = ['name', 'slug', 'owner_id', 'plan'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_user', 'workspace_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function forms()
    {
        return $this->hasMany(Forms::class, 'workspace_id');
    }
}
