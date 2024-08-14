<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'lastName',
        'patronymic',
        'image',
    ];
    public function specialize_employers(){
        return $this->hasMany(SpecializeEmployer::class);
    }
    public function specializes()
    {
        return $this->belongsToMany(Specialize::class, 'specialize_employers', 'employer_id', 'specialize_id');
    }
}
