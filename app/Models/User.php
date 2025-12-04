<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relación: Un usuario pertenece a muchos equipos
    public function equipos()
    {
        // Asumiendo que es una relación de muchos a muchos
        // Si te da error, verifica si tu relación es hasMany o belongsToMany
        return $this->belongsToMany(Equipo::class, 'equipo_user', 'user_id', 'equipo_id')
                    ->withPivot('rol'); // Si guardas el rol en la tabla intermedia
    }

    // Relación: Un usuario asiste a muchos eventos
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_user', 'user_id', 'evento_id');
    }
}
