<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="tarjeta")
 */
class Tarjeta
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    protected $numero;

    /**
     * @ORM\Column(type="float")
     */
    protected $disponible;

    /**
     * @OneToOne(targetEntity="Cliente")
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     * @var Cliente
    */
    protected $cliente;

    /**
    * @param $nombre
    * @param $numero
    * @param $disponible
    * @param $cliente
    */
    public function __construct($nombre, $numero, $disponible, $cliente)
    {
      $this->id = null;
      $this->nombre = $nombre;
      $this->numero = $numero;
      $this->disponible = $disponible;
      $this->cliente = $cliente;
    }

    public function getId(){return $this->id;}

    public function getNombre()     {return $this->nombre;}
    public function getNumero()     {return $this->numero;}
    public function getDisponible() {return $this->disponible;}
    public function getCliente()    {return $this->cliente;}

    public function setNombre($data)     {$this->nombre = $data;}
    public function setNumero($data)     {$this->numero = $data;}
    public function setDisponible($data) {$this->disponible = $data;}
    public function setCliente($data)    {$this->cliente = $data;}

    public function actualizarDatos($nombre, $numero, $disponible){
      $this->nombre = $nombre;
      $this->numero = $numero;
      $this->disponible = $disponible;
    }

    public function aceptaMonto($monto){
      if ($monto > $this->getDisponible()){
        throw new Exception('Limite superado');
      }
      return true;
    }

    public function restarMonto($monto){
      $this->disponible-=$monto;
    }
}