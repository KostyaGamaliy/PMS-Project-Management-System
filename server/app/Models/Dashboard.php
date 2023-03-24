<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $fillable = ['name', 'project_id'];

    public function projects() {
        return $this->belongsTo(Project::class);
    }
}
