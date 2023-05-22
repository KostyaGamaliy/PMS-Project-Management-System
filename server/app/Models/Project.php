<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    protected $guarded = false;
    protected $fillable = ['name', 'descriptions', 'preview_image', 'creator_id'];
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function dashboards() {
        return $this->hasMany(Dashboard::class);
    }

    public function roles() {
        return $this->hasMany(Role::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function getPdfPath(): Attribute
    {
        return Attribute::make(
            get: fn () => "storage/projects/project_report_{$this->id}.pdf"
        );
    }
}
