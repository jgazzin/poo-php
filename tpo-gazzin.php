<?php

// codigo TP01 JULIETA GAZZIN 

class alumno {
    public $apellido;
    public $materia;
    public $nota;
    public $aprobo;

    public function __construct($pApellido, $pMateria, $pNota) {
        $this->apellido = $pApellido;
        $this->materia = $pMateria;
        $this->nota = $pNota;

        //$alumno->apellido
        $esNombreValido = !empty($this->apellido);
            // corrección de datos
            while ($esNombreValido ==false) {
                echo "El apellido ingresado no es correcto\n";
                echo "Ingrese nuevamente el apellido: \n";
                $this->apellido = strtoupper(trim(fgets(STDIN)));
                $esNombreValido = !empty($this->apellido);
            }

        // $alumno->materia 
        $materiasValidas = ["POO", "MATEMATICAS", "BD"];
        $materia = $this->materia;
        $esMateriaValido = in_array($materia,$materiasValidas);
            // corrección de datos
            while ($esMateriaValido == false) {
                echo "La materia ingresada no es correcta\n";
                echo "Ingrese nuevamente la materia: \n";
                echo "POO - MATEMATICAS - INGLES\n";
                $materia = strtoupper(trim(fgets(STDIN)));
                $esMateriaValido = in_array($materia,$materiasValidas);
            }
        $this->materia = $materia;

        // $alumno->nota 
        $nota = $this->nota;
        $esNotaValido = ($nota <=10 && $nota > 0);
            // corrección de datos
            while ($esNotaValido == false) {
                echo "La nota ingresada no es válida\n";
                echo "Ingrese nuevamente la nota en números: \n";
                $nota = strtoupper(trim(fgets(STDIN)));
                $esNotaValido = ($nota <=10 && $nota > 0);
            }
        $this->nota = $nota;   
    }

}



class AlumnoRegular extends alumno {

    public $anioRegularidad;

    public function __construct($pApellido, $pMateria, $pNota, $pAnioRegularidad) {

        parent::__construct($pApellido, $pMateria, $pNota);
        $this->anioRegularidad = $pAnioRegularidad;

        // $alumno->anioRegularidad
        $anioRegularidad = $this->anioRegularidad;
        $esAnioValido = ($anioRegularidad > 1900 && $anioRegularidad <= 2022);
        // corrección de datos
        while ($esAnioValido == false) {
            echo "El año de regularidad no es válido\n";
            echo "Ingreselo nuevamente (AAAA): \n";
            $anioRegularidad = strtoupper(trim(fgets(STDIN)));
            $esAnioValido = ($anioRegularidad > 1900 && $anioRegularidad <= 2022);
        }
        $this->anioRegularidad = $anioRegularidad;

        if ($this->nota >4) {
            $this->aprobo = "SI";
        } else {
            $this->aprobo = "NO";
        }
    }            
}


class alumnoLibre extends alumno {

    public function __construct($pApellido, $pMateria, $pNota) {
        parent::__construct ($pApellido, $pMateria, $pNota);

        if ($this->nota >4) {
            $this->aprobo = "SI";
        } else {
            $this->aprobo = "NO";
        }
    }
}


//solo para regulares
function agregarAnioSiAlumnoRegular(){
    echo "Anio de regularización \n";
    $anio = strtoupper(trim(fgets(STDIN)));
    return $anio;
    // $alumno->anioRegularidad = $anio;
}

// instanceof
function esRegular($alumno) {
    if ($alumno instanceof AlumnoRegular) {
        $regular = "SI";
    } else {
        $regular = "NO";
    }
    return $regular;
}

function cargaDatosA($alumnoNota,$i){

    echo "ingrese los datos del alumno: \n";
    echo "apellido del alummo \n";
    $apellido = strtoupper(trim(fgets(STDIN)));
    echo "materia del alumno: \n";
    $materia = strtoupper(trim(fgets(STDIN)));
    echo "nota de la materia \n";
    $nota = rtrim(fgets(STDIN));
    echo "es regular la materia? S o N \n";
    $esRegular = strtoupper(trim(fgets(STDIN)));
    if($esRegular=="S"){
        $anioRegularidad =agregarAnioSiAlumnoRegular(); 
        $nuevoAlumno = new AlumnoRegular($apellido, $materia, $nota, $anioRegularidad);
 
    }else{
        $nuevoAlumno = new alumnoLibre($apellido, $materia, $nota);
    }
    $alumnoNota[$i] = $nuevoAlumno;

    return $alumnoNota;
}

function mostrarTodosAlumnos($alumnoNota){
    echo "Total Alumnos: ". count($alumnoNota) . "\n";
    echo "---\n";
    foreach($alumnoNota as $i=>$alumno){
        echo "Alumno #".($i+1)."\n";
        echo "Nombre: ".$alumno->apellido."\n";
        echo "Materia: ".$alumno->materia."\n";
        echo "Nota: ".$alumno->nota."\n";
        // instanceof
        // echo "Regular: ".$alumno->esRegular."\n";
        // anioRegularidad
        $regularidad =esRegular($alumno);
        echo "El alumno es regular: ". $regularidad. "\n";
        
        // $aprobo = $alumno->aproboAlumno();
        echo "Aprobó ".$alumno->aprobo."\n";

        echo "-------------------\n";
    }
}
function contarAlumnosXMateria($alumnoNota){
    $totmaterias = [];
    for($k=0; $k<count($alumnoNota); $k++){
        $alumnoActual = $alumnoNota[$k];
        $materia = $alumnoActual->materia;
        if (array_key_exists($materia,$totmaterias)){ //array_key_exits busca la clave elegida en el arreglo
            $totmaterias[$materia]++; //contador de materias incrementa en 1
        }else{
            $totmaterias[$materia]=1; // inicio en 1 una materia que no existia
        }
    }
    print_r($totmaterias);
}

function borrarAlumno ($alumnoNota) {
    echo "Elija el índice del alumno [] a borrar \n";
    print_r ($alumnoNota);
    $borrar = rtrim (fgets(STDIN));
    array_splice($alumnoNota, $borrar, 1);
    print_r ($alumnoNota);
    
    return $alumnoNota;
}


//Programa Principal

$exit=false; // variable centinela para salir de while
$alumnoNota=[]; // creacion de arreglo vacio
$i=0; // inicializar indice del arreglo

while ($exit == false) {
    echo "Elija una de las siguientes opciones: \n";
    echo "C - Carga de datos \n";
    echo "L - Leer los datos \n";
    echo "Q - Contar los datos \n";
    echo "B - Borrar datos \n";
    echo "S - Salir del programa \n";
    echo "Su opcion es: \n";
    $opcion=strtoupper(trim(fgets(STDIN)));

    switch ($opcion) {
        case "C":
            echo "Usted eligio Carga de Datos \n";
            $alumnoNota=cargaDatosA($alumnoNota,$i);
            print_r($alumnoNota);
            $i++;
            break;
        case "L":
            echo "Usted eligio Leer los Datos \n";
            // echo "Total de alumnos registrados \n";
            mostrarTodosAlumnos($alumnoNota);
            break;
        case "Q":
            echo "Usted eligio Contar los Datos \n";
            echo "Alumnos por materia \n";
            contarAlumnosXMateria($alumnoNota);
            break;       
        case "B":
            echo "Usted eligio Borrar Datos \n";
            $alumnoNota = borrarAlumno($alumnoNota);
            // corrección índice
            $i--;
            break;       
        case "S":
            echo "Gracias, usted saldra del programa \n";
            $exit=true;
            break;
        default:
            echo "Usted eligio una opcion incorrecta \n";
            break;

    }

}