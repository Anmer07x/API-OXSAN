<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paciente;
use App\Models\Resultado;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoPacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Patient
        $email = 'paciente@portal.com';

        $paciente = Paciente::where('email', $email)->first();

        if (!$paciente) {
            $paciente = Paciente::create([
                'tipo_documento' => 'CC',
                'numero_documento' => '12345678',
                'nombres' => 'Juan',
                'apellidos' => 'Perez (Demo)',
                'email' => $email,
                'password' => Hash::make('portal123'), // Simple password for demo
            ]);
            $this->command->info("Paciente creado: {$email}");
        } else {
            $this->command->info("El paciente {$email} ya existe.");
        }

        // 2. Create Signed Result (Visible)
        Resultado::firstOrCreate(
            ['codigo_orden' => 'DEMO-001', 'examen' => 'HEMOGRAMA COMPLETO'],
            [
                'paciente_id' => $paciente->id,
                'numero_documento' => $paciente->numero_documento,
                'resultado' => 'Normal',
                'unidad' => null,
                'valores_referencia' => null,
                'fecha_examen' => Carbon::now()->subDays(2),
                'fecha_validacion' => Carbon::now()->subDays(1), // Signed
                'exportado' => true,
            ]
        );

        // 3. Create Another Signed Result
        Resultado::firstOrCreate(
            ['codigo_orden' => 'DEMO-001', 'examen' => 'GLUCOSA'],
            [
                'paciente_id' => $paciente->id,
                'numero_documento' => $paciente->numero_documento,
                'resultado' => '92',
                'unidad' => 'mg/dL',
                'valores_referencia' => '70 - 100 mg/dL',
                'fecha_examen' => Carbon::now()->subDays(2),
                'fecha_validacion' => Carbon::now()->subDays(1), // Signed
                'exportado' => true,
            ]
        );

        // 4. Create Unsigned Result (Invisible in Portal)
        Resultado::firstOrCreate(
            ['codigo_orden' => 'DEMO-002', 'examen' => 'COLESTEROL TOTAL'],
            [
                'paciente_id' => $paciente->id,
                'numero_documento' => $paciente->numero_documento,
                'resultado' => '180',
                'unidad' => 'mg/dL',
                'valores_referencia' => '< 200 mg/dL',
                'fecha_examen' => Carbon::now(),
                'fecha_validacion' => null, // Not signed yet
                'exportado' => true,
            ]
        );
    }
}
