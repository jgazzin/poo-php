<?php

class Chip
{
    private $empresa;
    private $numero;

    function __construct($empresa, $numero){
        $this->empresa = $empresa;
        $this->numero = $numero;
    }

    public function mostrar()
    {
        echo "\tEmpresa: " . $this->empresa.PHP_EOL;
        echo "\tNumero de cel: " . strval($this->numero).PHP_EOL;
    }
}

class Bateria
{
    private $mAh;
    private $marca;
    function __construct($mAh, $marca){
        $this->mAh = $mAh;
        $this->marca = $marca;        
    }
    
    public function mostrar()
    {
        echo "Cantidad mAh: " . strval($this->mAh).PHP_EOL;
        echo "Marca Bat.: " . $this->marca.PHP_EOL;
    }
}


class Celular {
    private  $modelo;
    private  $bateria;
    private  $nroChips;
    private  $chips = [];

    public function __construct($modelo){
        $this->modelo=$modelo;
        $this->nroChips = 0;
    }
    
    public function morstrar(){
        echo "Modelo: ".$this->modelo.PHP_EOL;
        if($this->bateria) {
        	$this->bateria->mostrar();
        }
        echo "Número de chips: ".$this->nroChips. PHP_EOL;
        for ($i=0; $i < $this->nroChips; $i++){
            $this->chips[$i]->mostrar();
        }
    }
    
    public function agregarComponente($componente){
    	echo "Agregando: ".PHP_EOL;
    	$componente->mostrar();
    	echo "______________________".PHP_EOL;
    	if($componente instanceof Bateria){
    		$this->agregarBateria($componente);
    	}else if($componente instanceof Chip){
    		$this->agregarChip($componente);
    	}else {
    		echo "componente inválido".PHP_EOL;
    	}
    	
    }
    
    private function agregarBateria(Bateria $bateria){
    	$this->bateria = $bateria;
    }
    
    private function agregarChip(Chip $nuevoChip){
        if ($this->nroChips < 2){
            $this->chips[$this->nroChips]=$nuevoChip;
            $this->nroChips++;
        }
    } 
}

class Aplicacion{
    public static function iniciar(){
        $c1= new Celular ("A10PRO");
            
        $entel = new Chip("Entel", 7457854);
        $tigo = new Chip("Tigo", 83743843);
        
        $bat = new Bateria(3400, "Samsung");
        $c1->agregarComponente($entel);
        $c1->agregarComponente($tigo);
        $c1->agregarComponente($bat);
        
        $c1->morstrar();
    }
}

Aplicacion::iniciar();