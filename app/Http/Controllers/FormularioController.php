<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;
use SplTempFileObject;

class FormularioController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function index()
    {
        // Definir las rutas de los archivos JSON
        $rutaPaises = resource_path("paises.json");
        $rutaComunas = resource_path("comunas.json");
    
        // Variables para almacenar los datos
        $paises = [];
        $comunas = [];
    
        // Leer y decodificar paises.json
        if (File::exists($rutaPaises)) {
            $paisesJson = File::get($rutaPaises);
            $paises = json_decode($paisesJson, true);
    
            // Verificar si el JSON es válido
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Error al decodificar paises.json: " . json_last_error_msg());
                $paises = [];
            }
        } else {
            Log::warning("El archivo paises.json no existe.");
        }
    
        // Leer y decodificar comunas.json
        if (File::exists($rutaComunas)) {
            $comunasJson = File::get($rutaComunas);
            $comunas = json_decode($comunasJson, true);
    
            // Verificar si el JSON es válido
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Error al decodificar comunas.json: " . json_last_error_msg());
                $comunas = [];
            }
        } else {
            Log::warning("El archivo comunas.json no existe.");
        }
    
        // Pasar los datos a la vista
        return view('formulario', compact('paises', 'comunas'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nacionalidad' => 'required',
            'motivo_visita' => 'required',
            'descubrimiento' => 'required',
            'viaje' => 'required',
            'transporte' => 'required',
            'comuna' => 'required_if:nacionalidad,Chile' // Validación condicional
        ]);

        $respuesta = new Respuesta();
        $respuesta->hora = now()->format('H:i:s');
        $respuesta->fecha = now()->format('Y-m-d');
        $respuesta->nacionalidad = $request->nacionalidad;
        $respuesta->motivo_visita = $request->motivo_visita;
        $respuesta->descubrimiento = $request->descubrimiento;
        $respuesta->viaje = $request->viaje;
        $respuesta->transporte = $request->transporte;
        $respuesta->comuna = $request->comuna;
        $respuesta->save();

        return redirect()->back()->with('success', 'Datos guardados correctamente.');
    }
    public function generarCsv()
    {
        $registros = Respuesta::all();
        $nombre_archivo = "datos_turismo.csv";
    
        // Crear un archivo temporal en memoria
        $tempFile = new SplTempFileObject();
        $csv = Writer::createFromFileObject($tempFile); // Pasar el objeto SplTempFileObject al constructor
    
        // Agregar encabezados
        $csv->insertOne([
            "Hora", "Fecha", "Nacionalidad", "Motivo Principal de Visita",
            "Cómo se Enteró de Panguipulli", "Con Quién Viajó",
            "Medio de Transporte Principal", "Comuna de Residencia (Chile)"
        ]);
    
        // Agregar datos desde la base de datos
        foreach ($registros as $registro) {
            $csv->insertOne([
                $registro->hora,
                $registro->fecha,
                $registro->nacionalidad,
                $registro->motivo_visita,
                $registro->descubrimiento,
                $registro->viaje,
                $registro->transporte,
                $registro->comuna
            ]);
        }
        // Obtener el contenido del archivo CSV
        $csv_string = $tempFile->rewind() && $tempFile->fread($tempFile->getSize()); // Leer desde el inicio del archivo
    
        // Descargar el archivo CSV
        return Response::stream(function () use ($csv_string) {
            echo $csv_string;
        }, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"" . $nombre_archivo . "\""
        ]);
    }
}