<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{
    protected $table = 'invitations';
    protected $fillable = ['workspace_id', 'email', 'role', 'token', 'expires_at', 'created_at', 'accepted_at', 'accepted_at'];

    public function workspace()
    {
        return $this->belongsTo(Workspaces::class);
    }
}
