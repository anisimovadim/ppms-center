<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable=['title'];
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function block_elements(){
        return $this->hasMany(BlockElement::class);
    }
}
