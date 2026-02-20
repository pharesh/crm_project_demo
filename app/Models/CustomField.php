<?php

namespace App\Models;

use App\Models\ContactCustomFieldValue;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'field_name',
        'field_type',
        'field_options',
        'is_required'
    ];

    public function values()
    {
        return $this->hasMany(ContactCustomFieldValue::class);
    }

}
