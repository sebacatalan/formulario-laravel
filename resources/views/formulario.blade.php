@extends('layouts.app')

@section('title', 'Formulario de Turismo')

@section('content')
    <h1>Formulario de Turismo</h1>

    <form action="{{ route('guardar') }}" id="formulario" method="POST">
        @csrf
        <label for="nacionalidad">Nacionalidad:</label>
        <select name="nacionalidad" id="nacionalidad" onchange="verificarNacionalidad()">
            <option value="" selected>Seleccione...</option>
            @foreach ($paises as $pais)
                <option value="{{ $pais }}">{{ $pais }}</option>
            @endforeach
        </select>

        <div id="div_comuna" style="display: none;">
            <label for="comuna">Comuna de Residencia:</label>
            <select name="comuna" id="comuna" disabled>
                <option value="" selected>Seleccione...</option>
                @foreach ($comunas as $comunas_chile)
                    <option value="{{ $comunas_chile }}">{{ $comunas_chile }}</option>
                @endforeach
            </select>
        </div>

        <label for="motivo_visita">Motivo Principal de Visita:</label>
        <select name="motivo_visita" id="motivo_visita">
            <option value="" selected>Seleccione...</option>
            <option value="Naturaleza y aventura">Naturaleza y aventura</option>
            <option value="Cultura y patrimonio">Cultura y patrimonio</option>
            <option value="Gastronomía">Gastronomía</option>
            <option value="Relajación y bienestar">Relajación y bienestar</option>
            <option value="Eventos">Eventos (especificar)</option>
            <option value="Visita a familiares/amigos">Visita a familiares/amigos</option>
            <option value="Otro">Otro</option>
        </select>

        <label for="descubrimiento">Cómo se Enteró de Panguipulli:</label>
        <select name="descubrimiento" id="descubrimiento">
            <option value="" selected>Seleccione...</option>
            <option value="Internet">Internet</option>
            <option value="Recomendación">Recomendación</option>
            <option value="Medios">Medios</option>
            <option value="Oficina de turismo">Oficina de turismo</option>
            <option value="Otro">Otro</option>
        </select>

        <label for="viaje">Con Quién Viajó:</label>
        <select name="viaje" id="viaje">
            <option value="" selected>Seleccione...</option>
            <option value="Solo">Solo</option>
            <option value="En pareja">En pareja</option>
            <option value="Con familia">Con familia</option>
            <option value="Con amigos">Con amigos</option>
            <option value="En grupo">En grupo</option>
        </select>

        <label for="transporte">Medio de Transporte Principal:</label>
        <select name="transporte" id="transporte">
            <option value="" selected>Seleccione...</option>
            <option value="Auto">Auto</option>
            <option value="Bus">Bus</option>
            <option value="Moto">Moto</option>
            <option value="Bicicleta">Bicicleta</option>
            <option value="Otro">Otro</option>
        </select>

        <div style="display: flex; justify-content: space-between;">
            <button type="submit">Guardar</button>
            <a href="{{ route('descargar.csv') }}" class="btn btn-success">Descargar CSV</a>
        </div>
    </form>

    <div id="mensajes"></div>
@endsection

@section('scripts')
    <script>
        function verificarNacionalidad() {
            const nacionalidad = document.getElementById("nacionalidad");
            const div_comuna = document.getElementById("div_comuna");
            const comuna = document.getElementById("comuna");
            
            if (nacionalidad.value === "Chile") {
                div_comuna.style.display = "block";
                comuna.disabled = false;
            } else {
                div_comuna.style.display = "none";
                comuna.disabled = true;
                comuna.value = "";
            }
        }
    </script>
@endsection
