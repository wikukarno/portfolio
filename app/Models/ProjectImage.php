<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectImage extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'project_id',
        'image',
        'caption',
        'order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
