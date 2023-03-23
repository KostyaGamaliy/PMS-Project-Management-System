<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = false;
    protected $fillable = ['name', 'descriptions', 'preview_image'];
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function dashboards() {
        return $this->hasMany(Dashboard::class);
    }
}
