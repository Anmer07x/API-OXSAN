<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BridgeController extends Controller
{
    /**
     * Store or update a batch of results.
     *
     * Protected by 'auth.bridge' middleware.
     * 
     * Expects JSON:
     * [
     *   {
     *     "numero_documento": "12345",
     *     "codigo_orden": "ORD-001",
     *     "examen": "Hemograma",
     *     "resultado": "...",
     *     "fecha_examen": "2024-01-01 10:00:00",
     *     "fecha_validacion": "2024-01-01 12:00:00", (optional)
     *     ...
     *   },
     *   ...
     * ]
     */
    public function storeBatch(Request $request)
    {
        $data = $request->json()->all();

        if (!is_array($data)) {
            return response()->json(['error' => 'Invalid payload format. Expected array.'], 400);
        }

        $processed = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($data as $index => $item) {
                $validator = Validator::make($item, [
                    'numero_documento' => 'required|string',
                    'codigo_orden' => 'required|string',
                    'examen' => 'required|string',
                    'resultado' => 'required',
                    'fecha_examen' => 'required|date',
                ]);

                if ($validator->fails()) {
                    $errors[] = [
                        'index' => $index,
                        'errors' => $validator->errors()
                    ];
                    continue; // Skip invalid, or abort? Requirement says "Validar estructura". I'll skip and report.
                }

                // Try to find the patient to link
                $paciente = Paciente::where('numero_documento', $item['numero_documento'])->first();

                $resultadoData = [
                    'numero_documento' => $item['numero_documento'],
                    'paciente_id' => $paciente ? $paciente->id : null,
                    'codigo_orden' => $item['codigo_orden'],
                    'examen' => $item['examen'],
                    'resultado' => is_array($item['resultado']) ? json_encode($item['resultado']) : $item['resultado'],
                    'unidad' => $item['unidad'] ?? null,
                    'valores_referencia' => $item['valores_referencia'] ?? null,
                    'fecha_examen' => $item['fecha_examen'],
                    'fecha_validacion' => $item['fecha_validacion'] ?? null,
                    'exportado' => true,
                ];

                // Upsert based on codigo_orden + examen. 
                // Assumes one result per exam within an order.
                Resultado::updateOrCreate(
                    [
                        'codigo_orden' => $item['codigo_orden'],
                        'examen' => $item['examen']
                    ],
                    $resultadoData
                );

                $processed++;
            }

            DB::commit();

            return response()->json([
                'message' => 'Batch processed',
                'processed_count' => $processed,
                'errors' => $errors
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bridge batch error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }
}
