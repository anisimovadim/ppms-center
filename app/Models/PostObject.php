<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostObject extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'value', 'post_id', 'type'];
}
