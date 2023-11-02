<?php 

namespace App;

class Propiedad {

    // Base de datos
    protected static $db;
    protected static $columnasDb = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    // Errores - Validaciones
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = []){
        // Para hacer referencia a los atributos públicos se utiliza $this->nombreatributo | Estos no llevan el simbolo del dolar
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen']?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento']?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id= $args['vendedores_id'] ?? '';

    }

    public function guardar() {

        // Sanitizar los datos
        $atributos = $this->sanitizarDatos(); 

        // Insertar en la base de datos
        $query = " INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ( '";
        $query .= join("', '", array_values($atributos));
        $query .= "' ) ";
        

        $resultado = self::$db->query($query);

        debuguear($resultado);
    }

    // Definir la conexión a la base de datos
    public static function setDB($database) {
        // Para hacer referencia a atributos static se utiliza self:: los atributos static tambien llevan el simbolo $ delante
        self::$db = $database;
    }

    // Identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDb as $columna) {
            // Con el continue va a ignorar el id y va a continuar la ejecución
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        // Arreglo asociativo para poder acceder a la llave (titulo) y al valor (Lo que introduzca el usuario)
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Validación
    public static function getErrores() {
        return self::$errores;
    }

    public function validar(){
        if(!$this->titulo){
            self::$errores[] = 'Debes añadir un titulo';
        }

        if(!$this->precio){
            self::$errores[] = 'El precio es obligatorio';
        }

        if(!$this->imagen['name'] || $this->imagen['error']){
            self::$errores[] = 'La imagen es obligatoria';
        }

        if( strlen($this->descripcion) < 50 ){
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones){
            self::$errores[] = 'El número de habitaciones es obligatorio';
        }

        if(!$this->wc){
            self::$errores[] = 'El número de baños es obligatorio';
        }

        if(!$this->estacionamiento){
            self::$errores[] = 'El número de lugares de estacionamiento es obligatorio';
        }

        if(!$this->vendedores_id){
            self::$errores[] = 'El vendedor es obligatorio';
        }

        // Validar por tamaño (1mb máximo)
        $medida = 1000 * 1000;
        if($this->imagen['size'] > $medida){
            self::$errores[] = 'La imagen es muy grande';
        }

        return self::$errores;
    }








    
}


?>