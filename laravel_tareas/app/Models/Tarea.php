<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'estado',
        'fecha_limite',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    const ESTADOS = [
        'pendiente'   => 'Pendiente',
        'en_progreso' => 'En progreso',
        'completada'  => 'Completada',
        'cancelada'   => 'Cancelada',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDelUsuario(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}