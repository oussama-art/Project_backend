<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
