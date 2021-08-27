<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KidClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'time',
        'active'
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


    public function kids(){
        return $this->hasMany(Kid::class,'id','id_kid_classes');
    }
}
