<?php 
namespace App;

class Propiedad {

    // base de datos
    protected static $db;
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion',
    'habitaciones','wc','estacionamiento', 'creado', 'vendedorId'];
    // errores
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $descripcion;
    public $imagen;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;
    public static function setDB($database){
        // Objetos que se refieren a una una funcion protegida se refiere si mismo (self)
        self::$db = $database;
    }
    public function __construct($args = [])
    {
        // Formar el objeto
    $this->id = $args['id'] ?? '';
    $this->titulo = $args['titulo'] ?? '';
    $this->precio = $args['precio'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->imagen = $args['imagen'] ?? '';
    $this->descripcion = $args['descripcion'] ?? '';
    $this->habitaciones = $args['habitaciones'] ?? '';
    $this->wc = $args['wc'] ?? '';
    $this->estacionamiento = $args['estacionamiento'] ?? '';
    $this->creado = date('Y/m/d') ?? '';
    $this->vendedorId = $args['vendedorId'] ?? '';

        
    }

    public function guardar(){

        $atributos = $this->sanitizarDatos();
        // Query de lo que se obtiene del abckend
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";



        // para referirse a ella misma
        $resultado = self::$db->query($query);
        
        
        return $resultado;
    }

    // Definir la coneccion con la base de datos base de datos

    public function datos(){
        $atributos =[];
        foreach(self::$columnasDB as $columna){
            if($columna ==='id') continue;
            $atributos[$columna] = $this-> $columna;
        }
        return $atributos;
    }
    public function sanitizarDatos(){
        $atributos = $this->datos(); 
        $sanitizado =[];
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public  function setImagen($imagen){
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    public static function getErrores(){
        return self::$errores;
    }

    public function validar() {

        if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->precio){
            self::$errores[] = 'tienes que colocar un precio';
        }
       

        if( strlen($this->descripcion) < 50){
            self::$errores[] = 'tienes que colocar ,mas caracteres (5)';
        }

        if(!$this->precio){
            self::$errores[] = 'tienes que colocar un precio';
        }
       
        if(!$this->habitaciones){
            self::$errores[] = 'tienes que colocar el numero de habitaciones';
        }
        if(!$this->wc){
            self::$errores[] = 'tienes que colocar el numero de baños';
        }
        if(!$this->estacionamiento){
            self::$errores[] = 'tienes que colocar el numero de estacionamientos';
        }
        if(!$this->vendedorId){
            self::$errores[] = 'seleccione un perfil';
        }
         if(!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        } 
        return self::$errores;
    }
}