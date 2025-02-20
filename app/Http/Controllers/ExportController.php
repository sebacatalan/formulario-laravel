<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta; // Asegúrate de usar el modelo correcto
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function descargarCSV()
    {
        // Obtener los registros de la base de datos
        $registros = Respuesta::select('id', 'hora', 'fecha', 'nacionalidad', 'motivo_visita', 'descubrimiento', 'viaje', 'transporte', 'comuna')->get();

        // Crear el contenido del CSV
        $csvData = "ID,Hora,Fecha,Nacionalidad,Motivo Visita,Descubrimiento,Viaje,Transporte,Comuna\n";
        
        foreach ($registros as $registro) {
            $csvData .= "{$registro->id},{$registro->hora},{$registro->fecha},{$registro->nacionalidad},"
                      . "{$registro->motivo_visita},{$registro->descubrimiento},{$registro->viaje},"
                      . "{$registro->transporte},{$registro->comuna}\n";
        }

        // Definir el nombre del archivo
        $fileName = 'registros.csv';

        // Devolver el archivo CSV como descarga
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ]);
    }
}