<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// app/Models/User.php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    //  Un utilisateur peut créer plusieurs projets
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    //  Un utilisateur peut recevoir plusieurs tâches
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
