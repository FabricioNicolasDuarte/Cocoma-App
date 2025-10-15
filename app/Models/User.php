<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;
// Añadimos los 'use' para Storage y Str
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Un usuario puede tener muchos proyectos.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // --- CÓDIGO AÑADIDO ---
    /**
     * Obtiene la URL completa del avatar del usuario.
     *
     * Este "accesor" genera automáticamente la URL correcta,
     * ya sea desde Amazon S3 o desde el almacenamiento local para el avatar por defecto.
     * En tus vistas, simplemente usa: {{ Auth::user()->avatar_url }}
     */
    public function getAvatarUrlAttribute(): string
    {
        // Si el campo 'avatar' contiene 'avatars', asumimos que es una ruta de S3.
        if ($this->avatar && Str::startsWith($this->avatar, 'avatars')) {
            return Storage::disk('s3')->url($this->avatar);
        }

        // Si no, devuelve la ruta al avatar por defecto usando asset().
        // Usamos 'images/avatars/default.png' como valor predeterminado si 'avatar' está vacío.
        return asset($this->avatar ?: 'images/avatars/default.png');
    }
    // --- FIN DEL CÓDIGO AÑADIDO ---
}

