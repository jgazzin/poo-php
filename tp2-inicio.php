<?php

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
        echo "-------------------\n";
        echo "ID: " . $this->id . "\n";
        echo "apellido: " . $this->apellido. "\n";
        echo "materia: " . $this->materia . "\n";
        echo "nota: " . $this->nota . "\n";
        echo "Aprobo: " . $this->aprobo . "\n";
    }

    public function imprimirErrores() {
        echo "Errores: \n";
        if (empty($this->errores)){
            echo "Alumno Válido\n";
        } else {
            foreach ($this->errores as $error) {
                echo "- " . $error . "\n";
            }
        }
        echo "-----------------\n";
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
        parent::imprimirErrores();
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
        parent::imprimirErrores();
    }  

}




class Utiles {
    public static function pedirInformacion($mensaje, $mayuscula=true, $quitarEspacios=true){
        echo "$mensaje: ".PHP_EOL;
        $entradaUsuario = fgets(STDIN);
        if($mayuscula){
            $entradaUsuario = strtoupper($entradaUsuario);
        }
        if($quitarEspacios){
            $entradaUsuario = trim($entradaUsuario);
        }        
        return $entradaUsuario;
    }
}

class Menu {
    private $opciones = [
                'A'=>'Cargar datos',
                'B'=>'Borrar datos',
                'M'=>'Modificar',
                'L'=>'Buscar alumnos por apellido',
                'S'=>'Salir'
            ];    
    public function __construct(){
    }

    public function presentarOpciones(){
        foreach($this->opciones as $opcion=>$mensaje){
            echo "$opcion - $mensaje".PHP_EOL;
        }
    }

    public function ejecutarAccion($opcion, $datosEjercicio, &$errores){
        $nuevoDatosEjercicio = $datosEjercicio;
        // COMPLETAR LAS DEMÁS OPCIONES DEL SWITCH DE ACUERDO AL MENU

        switch($opcion){
            // A- cargar datos
            case "A":
                echo "Usted eligio Carga de Datos \n";
                $nuevoDatosEjercicio = $this->cargarDatos($nuevoDatosEjercicio, $errores);
                break;

            // B - borrar datos
            case "B":
                echo "Usted eligio Borrar Datos \n";
                $nuevoDatosEjercicio = $this->borrarDatos($nuevoDatosEjercicio, $errores);
                break;   

            case "L":
                echo "Ejecutando LISTAR DATOS".PHP_EOL; 
                $this->listarDatos($datosEjercicio);
                break;
        }
        return $nuevoDatosEjercicio;
    }

    private function listarDatos($datosEjercicio){
        // pedir el apellido a buscar
        // var_dump($datosEjercicio);
        echo "Total Alumnos: ". count($datosEjercicio) . "\n";
        foreach($datosEjercicio as $i=>$alumno){
            echo $alumno->imprimirDatos();
        }
    
    }


    private function cargarDatos($datosEjercicio, &$errores){

        $apellido = Utiles::pedirInformacion("Ingrese apellido del alumno:");
        $materia = Utiles::pedirInformacion("materia del alumno:");
        $nota = Utiles::pedirInformacion("Ingrese la nota:");
        $esRegular = Utiles::pedirInformacion("es regular la materia? S o N ");
        // índice para el ID (para q no se repitan Id si no se graba nombre)
        $i=count($datosEjercicio);
        if($esRegular=="S"){
            $anioRegularidad = Utiles::pedirInformacion("Anio de regularización:");
            $nuevoAlumno = new AlumnoRegular($apellido, $materia, $nota, $anioRegularidad, $i);
        }else{
            $nuevoAlumno = new alumnoLibre($apellido, $materia, $nota, $i);
        }
        $datosEjercicio[$nuevoAlumno->id()] = $nuevoAlumno;
        print_r ($datosEjercicio);  //control
        return $datosEjercicio;

    }

    private function pedirDatosAlumno(){
        // ?? para pedir datos al usuarios usé pedirInformacion()
    }


    private function borrarDatos($datosEjercicio, &$errores){
        $this->listarDatos($datosEjercicio);
        $borrar = Utiles::pedirInformacion("Elija el ID del alumno a borrar \n");
        if(array_key_exists($borrar, $datosEjercicio)){
            echo "Borrar: " . $borrar ."\n";
            unset($datosEjercicio[$borrar]);
            $this->listarDatos($datosEjercicio);      
        } else {
            echo "ID inexistente".PHP_EOL;
        }
        return $datosEjercicio;
    }


    private function modificarDatos($datosEjercicio, &$errores){

    }

}

class Ejercicio {
    private $menu;
    private $datosEjercicio = [];

    public function __construct(){
        $this->menu = new Menu();
    }

    public function iniciarEjercicio(){
        do {
            $this->menu->presentarOpciones();
            $opcion = Utiles::pedirInformacion('Elija una opción');
            echo "usted eligió $opcion".PHP_EOL;
            $errores = [];

            $this->datosEjercicio = $this->menu->ejecutarAccion($opcion, $this->datosEjercicio, $errores);        

        }while($opcion!=="S");
    }
}

$ejercicio = new Ejercicio();
$ejercicio->iniciarEjercicio();