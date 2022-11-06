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
    protected $id;
    protected $apellido;
    protected $materia;
    protected $nota;
    protected $aprobo;
    protected $errores = [];

    public function __construct($pApellido, $pMateria, $pNota) {
        $this->apellido = $pApellido;
        $this->materia = $pMateria;
        $this->nota = $pNota;
       
    }

    public function materia(){
        return $this->materia;
    }

    //validar datos
    public function validar(){
        //$alumno->apellido
        if (empty($this->apellido)){
            $this->errores[] = "Apellido vacío";
        }

        // $alumno->materia 
        if (empty($this->materia)){
            $this->errores[] = "Materia vacío";
        } else {
            $materiasValidas = [
                "POO", 
                "MATEMATICAS", 
                "BD"];
            $esMateriaValido = in_array($this->materia, $materiasValidas);
            if ($esMateriaValido == false) {
                $this->errores[] = "Materia no válida";
            }
        }

        // $almno->validarNota
        if (empty($this->nota)){
            $this->errores [] = "Nota vacía";
            } else {
                if(!is_numeric($this->nota)){
                    $this->errores [] = "Valor no numérico";
                } else {
                    if ($this->nota >10 || $this->nota < 0){
                    $this->errores [] = "Nota no válida (0-10)";
                }
            }
        }
    
    }


    // leerDatos
    public function imprimirDatos () {
        echo "---\n";
        echo "ID: " . $this->id . "\n";
        echo "apellido: " . $this->apellido. "\n";
        echo "materia: " . $this->materia . "\n";
        echo "nota: " . $this->nota . "\n";
        echo "Aprobo: " . $this->aprobo . "\n";
    }
}



class AlumnoRegular extends Alumno {

    protected $anioRegularidad;

    public function __construct($pApellido, $pMateria, $pNota, $pAnioRegularidad, $i) {

        parent::__construct($pApellido, $pMateria, $pNota, $i);
        $this->id = "AR{$this->apellido}-{$i}";
        $this->anioRegularidad = $pAnioRegularidad;
        $this->aprobo();
        $this->validar();
    }

    // validar datos
    public function validar(){
        parent::validar();
        // anios regularidad
        if (empty($this->anioRegularidad)){
            $this->errores[] = "Año Regularidad vacío";
            } else {
                if (!is_numeric($this->anioRegularidad)){
                    $this->errores[] = "Año de regularidad no es numérico";
                    } else {
                    if ($this->anioRegularidad < 1900 ||
                    $this->anioRegularidad > 2022) {
                    $this->errores[] = "El año regularidad no es válido (1900/2022)";
                    
                }
            }

        }
    }

    public function id(){
        return $this->id;
    }

    public function aprobo(){
        if (!empty($this->nota)){
            if ($this->nota >6) {
                $this->aprobo = "SI";
            } else {
                $this->aprobo = "NO";
            }
        }
    }

    public function imprimirDatos (){
        parent::imprimirDatos();
        echo "Alumno regular".PHP_EOL;
        echo "año regularidad: " . $this->anioRegularidad . "\n";
        echo "Errores: \n";
        if (empty($this->errores)){
            echo "Alumno Válido\n";
        } else {
            foreach ($this->errores as $error) {
                echo "- " . $error . "\n";
            }
        }

    }    

}


class AlumnoLibre extends Alumno {

    public function __construct($pApellido, $pMateria, $pNota, $i) {
        parent::__construct ($pApellido, $pMateria, $pNota, $i);
        $this->id = "AL{$this->apellido}-{$i}";
        $this->aprobo(); 
        parent::validar();
    }

    public function id(){
        return $this->id;
    }

    public function aprobo(){
        if (!empty($this->nota)){
            if ($this->nota >4) {
                $this->aprobo = "SI";
            } else {
                $this->aprobo = "NO";
            } 
        }

    } 

    public function imprimirDatos (){
        parent::imprimirDatos();
        echo "Alumno Libre".PHP_EOL;
        echo "Errores: \n";
        if (empty($this->errores)){
            echo "Alumno Válido\n";
        } else {
            foreach ($this->errores as $error) {
                echo $error . "\n";
            }
        }
    }  

}

/* --- FUNCIONES -- */

//solo para regulares
function agregarAnioSiAlumnoRegular(){
    $anio = readline("Anio de regularización \n");
    return $anio;
}


function cargaDatosA($alumnoNota,$i){

    echo "ingrese los datos del alumno: \n";
    $apellido = strtoupper(readline("apellido del alummo \n"));
    $materia = strtoupper(readline("materia del alumno: \n"));
    $nota = strtoupper(readline("Ingrese la nota: \n"));
    $esRegular = strtoupper(readline("es regular la materia? S o N \n"));
    if($esRegular=="S"){
        $anioRegularidad = agregarAnioSiAlumnoRegular(); 
        $nuevoAlumno = new AlumnoRegular($apellido, $materia, $nota, $anioRegularidad, $i);
    }else{
        $nuevoAlumno = new alumnoLibre($apellido, $materia, $nota, $i);
    }
    $alumnoNota[$nuevoAlumno->id()] = $nuevoAlumno;
    print_r ($alumnoNota);  //control
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
        $materia = $alumno->materia();
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
    $borrar = strtoupper(readline("Elija el ID del alumno a borrar \n"));
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
$alumnoNota ["ARAL1-0"]= new alumnoRegular ("AL1", "POO", "7", "2022",0);
$alumnoNota ["ALAL2-1"]= new alumnoLibre ("AL2", "BD", "4",1);
$alumnoNota ["ALAL3-2"]= new alumnoLibre ("AL3", "BD", "2",2);
$alumnoNota ["ARAL4-3"]= new alumnoRegular ("AL4", "POO", "3", "2022",3);

// correcció índice
$i = count($alumnoNota);

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
            //corrección índice
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

?>