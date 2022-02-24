<?

class Producto{
    private $codigo;
    private $nombre;
    private $descripcion;
    private $alta;
    private $baja;

    public function __construct($codigo,$nombre,$desc)
    {
        $this->codigo = $codigo;
        $this->codigo = $nombre;
        $this->codigo = $desc;

    }

    public function __get($var){
        return $this->$var;
    }
}