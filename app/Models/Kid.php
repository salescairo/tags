<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kid extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'identification',
        'active',
        'responsable1_name',
        'responsable1_phone',
        'responsable2_name',
        'responsable2_phone',
        'photo',
        'id_kid_class',
        'id_user',
    ];


    public function setActiveAttribute($value)
    {
        if ($value != null) {
            $this->attributes['active'] = boolval($value);
        }
    }
    public function getActiveAttribute()
    {
        return boolval($this->attributes['active']);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function class()
    {
        return $this->belongsTo(KidClass::class, 'id_kid_class', 'id');
    }
    public function photo()
    {
        return Storage::url($this->attributes['photo']);
    }
}
