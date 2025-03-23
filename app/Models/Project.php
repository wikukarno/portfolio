<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'category_project_id',
        'title',
        'slug',
        'short_summary',
        'description',
        'repository_url',
        'live_url',
        'is_featured',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryProject::class, 'category_project_id');
    }

    public function techStacks()
    {
        return $this->belongsToMany(TechStack::class, 'project_tech_stacks');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }
}
