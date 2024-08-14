<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;
    protected $fillable=['value', 'type'];
    public function block_element(){
        return $this->belongsTo(BlockElement::class);
    }
}
