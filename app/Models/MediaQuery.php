<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaQuery extends Model
{
    use HasFactory;
    protected $fillable=['title', 'block_element_id', 'style_id'];
    public function block_element(){
        return $this->belongsTo(BlockElement::class);
    }
    public function style(){
        return $this->belongsTo(Style::class);
    }

}
