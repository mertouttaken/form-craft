<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $table = 'forms';
    protected $fillable = ['workspace_id', 'title', 'description', 'public_slug', 'status', 'settings', 'submissions_count'];

    public function workspace()
    {
        return $this->belongsTo(Workspaces::class);
    }
    public function fields()
    {
        return $this->hasMany(Fields::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submissions::class);
    }
}
