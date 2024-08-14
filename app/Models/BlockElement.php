<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockElement extends Model
{
    use HasFactory;
    protected $fillable=['block_id', 'element_id'];
    public function block(){
        return $this->belongsTo(Block::class);
    }
    public function media_queries(){
        return $this->hasMany(MediaQuery::class);
    }
    public function element(){
        return $this->belongsTo(Element::class);
    }
}
