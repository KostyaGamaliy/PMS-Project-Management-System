<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $fillable = ['user_id', 'assigner_id', 'dashboard_id', 'name', 'description', 'status'];

    public function dashboards() {
        return $this->belongsTo(Dashboard::class);
    }

    public function users() {
        return $this->belongsTo(User::class);
    }
}
