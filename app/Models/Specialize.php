<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialize extends Model
{
    use HasFactory;
    public function specialize_employers(){
        return $this->hasMany(SpecializeEmployer::class);
    }
    public function employers()
    {
        return $this->belongsToMany(Employer::class, 'specialize_employers', 'specialize_id', 'employer_id');
    }
}
