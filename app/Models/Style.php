<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;
    protected $fillable=['top', 'left', 'width', 'size', 'classes'];
    public function media_queries(){
        return $this->hasMany(MediaQuery::class);
    }
}
