<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecializeEmployer extends Model
{
    use HasFactory;
    protected $fillable=[
        'employer_id',
        'specialize_id',
    ];
    public function employer(){
        return $this->belongsTo(Employer::class);
    }
    public function specialize(){
        return $this->belongsTo(Specialize::class);
    }
}
