<?php

// codigo TP02/1 CORRECCIÓN
/*
- (1) Utilizar conceptos de herencia e invocación de métodos padres cuando corresponda. 
Cambiar visibilidad de los atributos y utilizar métodos en los lugares donde accedíamos a los atributos que van a a tener una visibilidad distinta

- (2) Incorporar un atributo ID, que sea la clave del elemento en el arreglo (ya no vamos a un arreglo indexado, sino uno asociativo) y un atributo ERRORES para persistir la información delos errores de validación (relacionado al punto siguiente)

- (3) Utilizar la estrategia de comunicación de errores vista en la materia (no hacer echo en el método que valida)

- (4) Agregar un método imprimir en las clase. El método que lista los objetos, no tiene que saber cómo mostrarlo, sino tiene que invocar a un método IMPRIMIR presente en las clases (Nota: el imprimir ya no va a necesitar el instanceof)
*/

class Alumno {
    public $id;
    public $apellido;
    public $materia;
    public $nota;
    protected $aprobo;

    public function __construct($pApellido, $pMateria, $pNota) {
        $this->apellido = $pApellido;
        $this->materia = $pMateria;
        $this->nota = $pNota;

    }

    // leerDatos
    function imprimirDatos () {
        echo "---\n";
        echo "ID: " . $this->id . "\n";
        echo "apellido: " . $this->apellido. "\n";
        echo "materia: " . $this->materia . "\n";
        echo "nota: " . $this->nota . "\n";
        echo "aprobo:" . $this->aprobo . "\n";
    }

}



class AlumnoRegular extends Alumno {

    protected $anioRegularidad;

    public function __construct($pApellido, $pMateria, $pNota, $pAnioRegularidad) {

        parent::__construct($pApellido, $pMateria, $pNota);
        $this->id = "AR{$pApellido}";
        $this->anioRegularidad = $pAnioRegularidad;
           
        if ($pNota >6) {
            $this->aprobo = "SI";
        } else {
            $this->aprobo = "NO";
        }
    }
    public function imprimirDatos (){
        parent::imprimirDatos();
        echo "Alumno regular".PHP_EOL;
        echo "año regularidad: " . $this->anioRegularidad . "\n";
    }    

}


class AlumnoLibre extends Alumno {

    public function __construct($pApellido, $pMateria, $pNota) {
        parent::__construct ($pApellido, $pMateria, $pNota);
        $this->id = "AL".$pApellido;
        if ($pNota >4) {
            $this->aprobo = "SI";
        } else {
            $this->aprobo = "NO";
        } 
    }
}

/* --- FUNCIONES -- */

function validarApellido($apellido) {
    //$alumno->apellido
    $esNombreValido = !empty($apellido);
    // corrección de datos
    while ($esNombreValido == false) {
        echo "El apellido ingresado no es correcto\n";
        echo "Ingrese nuevamente el apellido: \n";
        $apellido = strtoupper(trim(fgets(STDIN)));
        $esNombreValido = !empty($apellido);
    }
    return $apellido;
}

function validarMateria ($materia) {
    // $alumno->materia 
    $materiasValidas = ["POO", "MATEMATICAS", "BD"];
    $esMateriaValido = in_array($materia,$materiasValidas);
        // corrección de datos
        while ($esMateriaValido == false) {
            echo "La materia ingresada no es correcta\n";
            echo "Ingrese nuevamente la materia: \n";
            echo "POO - MATEMATICAS - BD\n";
            $materia = strtoupper(trim(fgets(STDIN)));
            $esMateriaValido = in_array($materia,$materiasValidas);
        }
        return $materia;
}

function validarNota ($nota) {
    // $alumno->nota 
    $esNotaValido = ($nota <=10 && $nota > 0);
        // corrección de datos
        while ($esNotaValido == false) {
            echo "La nota ingresada no es válida\n";
            echo "Ingrese nuevamente la nota en números: \n";
            $nota = strtoupper(trim(fgets(STDIN)));
            $esNotaValido = ($nota <=10 && $nota > 0);
        }
        return $nota;
}


//solo para regulares
function agregarAnioSiAlumnoRegular(){
    echo "Anio de regularización \n";
    $anio = strtoupper(trim(fgets(STDIN)));

        // $alumno->anioRegularidad
        $esAnioValido = ($anio > 1900 && $anio <= 2022);
        // corrección de datos
        while ($esAnioValido == false) {
            echo "El año de regularidad no es válido\n";
            echo "Ingreselo nuevamente (AAAA): \n";
            $anio = strtoupper(trim(fgets(STDIN)));
            $esAnioValido = ($anio > 1900 && $anio <= 2022);
        }
    return $anio;
}


function cargaDatosA($alumnoNota,$i){

    echo "ingrese los datos del alumno: \n";
    echo "apellido del alummo \n";
    $apellido = validarApellido(strtoupper(trim(fgets(STDIN))));
    echo "materia del alumno: \n";
    $materia = validarMateria(strtoupper(trim(fgets(STDIN))));
    echo "nota de la materia \n";
    $nota = validarNota(rtrim(fgets(STDIN)));
    echo "es regular la materia? S o N \n";
    $esRegular = strtoupper(trim(fgets(STDIN)));
    if($esRegular=="S"){
        $anioRegularidad =agregarAnioSiAlumnoRegular(); 
        $nuevoAlumno = new AlumnoRegular($apellido, $materia, $nota, $anioRegularidad);
        
    }else{
        $nuevoAlumno = new alumnoLibre($apellido, $materia, $nota);
    }
    $alumnoNota[$nuevoAlumno->id] = $nuevoAlumno;
    // print_r ($alumnoNota);  //control
    return $alumnoNota;
}

function mostrarTodosAlumnos($alumnoNota=[]){
    // print_r($alumnoNota);   //CONTROL

    echo "Total Alumnos: ". count($alumnoNota) . "\n";
    echo "---\n";
    foreach($alumnoNota as $i=>$alumno){
        echo $alumno->imprimirDatos();
    }

}

function contarAlumnosXMateria($alumnoNota){
    $totmaterias = [];
    foreach ($alumnoNota as $alumno) {
        $materia = $alumno->materia;
        if (array_key_exists($materia,$totmaterias)){
            $totmaterias[$materia]++;
        }else{
            $totmaterias[$materia]=1;
        }
    }

    print_r($totmaterias);
}

function borrarAlumno ($alumnoNota) {
    // print_r ($alumnoNota);
    mostrarTodosAlumnos($alumnoNota);
    var_dump($alumnoNota);
    echo "Elija el ID del alumno a borrar \n";
    $borrar = strtoupper(rtrim(fgets(STDIN)));
    if(array_key_exists($borrar, $alumnoNota)){
        echo "Borrar: " . $borrar ."\n";
        unset($alumnoNota[$borrar]);
        mostrarTodosAlumnos($alumnoNota);        
    } else {
        echo "ID inexistente".PHP_EOL;
    }
    return $alumnoNota;
}


//Programa Principal

$exit=false; // variable centinela para salir de while
$alumnoNota=[]; // creacion de arreglo vacio
$i=0; // inicializar indice del arreglo

// DEMO control del programa
$alumnoNota ["ARAL1"]= new alumnoRegular ("AL1", "POO", "7", "2022");
$alumnoNota ["ALAL2"]= new alumnoLibre ("AL2", "BD", "4");
$alumnoNota ["ALAL3"]= new alumnoLibre ("AL3", "BD", "2");
$alumnoNota ["ARAL4"]= new alumnoRegular ("AL4", "POO", "3", "2022");

while ($exit == false) {
    echo "---\n";
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
            // $i--;
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

?>