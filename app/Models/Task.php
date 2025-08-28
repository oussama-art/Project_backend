<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'assigned_to',
    ];

    protected $casts = [
        'status' => TaskStatus::class, // 🔥 Laravel cast automatiquement en Enum
    ];

   // Une tâche appartient à un projet.
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

   // Une tâche est assignée à un utilisateur.
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
