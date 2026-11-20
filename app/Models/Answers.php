<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $table = 'answers';
    protected $fillable = ['submission_id', 'field_id', 'value'];

    public function submission()
    {
        return $this->belongsTo(Submissions::class);
    }
    public function field()
    {
        return $this->belongsTo(Fields::class);
    }
}
