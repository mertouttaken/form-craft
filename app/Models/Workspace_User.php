<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace_User extends Model
{
    protected $table = 'workspace_user';
    protected $fillable = ['workspace_id', 'user_id', 'role'];

    public function workspace()
    {
        return $this->belongsTo(Workspaces::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
