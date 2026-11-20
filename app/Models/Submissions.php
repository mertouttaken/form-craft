<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submissions extends Model
{
    protected $table = 'submissions';

    protected $fillable = ['form_id', 'submitted_at', 'ip_hash', 'user_agent'];

    public function form()
    {
        return $this->belongsTo(Forms::class);
    }

    public function answers()
    {
        return $this->hasMany(Answers::class, 'submission_id');
    }
}
