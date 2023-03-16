<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = false;
    protected $fillable = ['name', 'descriptions', 'preview_image'];
    use HasFactory;

}
