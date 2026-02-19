<?php

namespace App\Models;

use App\Models\ContactCustomFieldValue;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'field_type',
        'is_required'
    ];

    public function values()
    {
        return $this->hasMany(ContactCustomFieldValue::class);
    }

}
