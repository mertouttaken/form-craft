<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $table = 'fields';
    protected $fillable = ['form_id', 'type', 'label', 'placeholder', 'help_text', 'is_required', 'options', 'rules', 'position', 'settings', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo(Forms::class);
    }
}
