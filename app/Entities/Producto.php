<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="producto")
 */
class Producto
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
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     */
    protected $categoria;

    /**
     * @ORM\Column(type="float")
     */
    protected $precio;

    /**
    * @param $descripcion
    * @param $categoria
    * @param $precio
    */
    public function __construct($descripcion, $categoria, $precio)
    {
      $this->id = null;
      $this->descripcion = $descripcion;
      $this->categoria = $categoria;
      $this->precio = $precio;
    }

    public function getId(){return $this->id;}

    public function getDescripcion(){return $this->descripcion;}
    public function getCategoria()  {return $this->categoria;}
    public function getPrecio()     {return $this->precio;}

    public function setDescripcion($data)   {$this->descripcion = $data;}
    public function setCategoria($data)     {$this->categoria = $data;}
    public function setPrecio($data)        {$this->precio = $data;}
}