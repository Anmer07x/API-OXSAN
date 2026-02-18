<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Resultado extends Model
{
    use HasFactory;

    protected $table = 'resultados';

    protected $fillable = [
        'paciente_id',
        'numero_documento',
        'codigo_orden',
        'examen',
        'resultado',
        'unidad',
        'valores_referencia',
        'fecha_examen',
        'fecha_validacion',
        'exportado',
    ];

    protected $casts = [
        'fecha_examen' => 'datetime',
        'fecha_validacion' => 'datetime',
        'exportado' => 'boolean',
    ];

    /**
     * Get the patient that owns the result.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Scope a query to only include signed results.
     */
    public function scopeSigned(Builder $query): void
    {
        $query->whereNotNull('fecha_validacion');
    }
}
