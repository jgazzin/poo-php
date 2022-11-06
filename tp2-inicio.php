<?php
/**
 * Aquí debemos agregar las clases relacionadas al alumno, podemos pegarlas una abajo
 * de la otra, o para quienes se animen, pueden investigar require_once
 */

 // COMPLETAR CON LAS DEFINICIONES DE LAS CLASES ALUMNO Y ALUMNO REGULAR, ADECUADAS
 // CON LA HERENCIA Y LA VISIBILIDAD DE ATRIBUTOS ESPERADA



/**
 * Clase solamente utilizada para agrupar funciones comunes al sistema
 */
class Utiles {
    /**
     * Recibe un mensaje, que es un string le pide al usuario con ese mensaje
     * que ingrese un valor
     * el parámetro $mayuscula determina si se espera que la cadena sea convertida a mayúscula
     * el parámetro $trim determina si se espera que se le quiten los espacios a la cadena obtenida
     */
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
            case "L":
                echo "Ejecutando LISTAR DATOS".PHP_EOL; 
                $this->listarDatos($datosEjercicio);
                break;
        }
        return $nuevoDatosEjercicio;
    }

    private function listarDatos($datosEjercicio){
        // pedir el apellido a buscar
        var_dump($datosEjercicio);
        // para cada elemento.. invocar la función IMPRIMIR de ese objeto para mostrarlo
        // QUITAR VAR_DUMP Y COMPLETAR

    
    }
    /**
     * recibe los datos del ejercicio, le pide al usuario los datos para un nuevo
     * alumno, lo agrega a la lista y lo devuelve al método que lo invocó
     * TIP: utilizar otro método para tomar los datos del usuario y luego con ese 
     * resultado, cargarlo al listado
     */
    private function cargarDatos($datosEjercicio, &$errores){
        // COMPLETAR
    }

    /**
     * función para interactuar con el usuario, pidiendo los datos que van a componer el 
     * alumno resultante.
     * Devuelve un nuevo objeto a quién lo invoca
     */
    private function pedirDatosAlumno(){

    }

    /**
     * recibe los datos del ejercicio, muestra los datos actuales, le pide al usuario
     * la PK del elemento a borrra, lo borra de la lista y devuelve la lista al método que
     * lo invocó
     */
    private function borrarDatos($datosEjercicio, &$errores){

    }

    /**
     * recibe los datos del ejercicio, muestra los datos actuales, le pide al usuario
     * la PK del elemento a modificar, le pide al usuario los nuevos datos, cambia el elemento de la lista y
     * devuelve la lista al método que lo invocó
     * TIP: utilizar otro método para tomar los datos del usuario y luego con ese 
     * resultado, reemplazar el elemento anterior: quitar el anterior y agregar el nuevo es válido
     */
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
            // inicializo los errores en vacío antes de invocar la acción
            $errores = [];

            // reemplazo los datos actuales, por los que resulten de realizar la acción elegida.
            // además envío la variable $errores para obtener información de la ejecución    
            $this->datosEjercicio = $this->menu->ejecutarAccion($opcion, $this->datosEjercicio, $errores);        
            // luego de la función, me fijo si volvieron errores y los imprimo
        }while($opcion!=="S");
    }
}

$ejercicio = new Ejercicio();
$ejercicio->iniciarEjercicio();