<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Categoria;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

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
     * One Product has One Category.
     * @ManyToOne(targetEntity="Categoria")
     * @JoinColumn(name="categoria_id", referencedColumnName="id")
     * @var Categoria
    */
    protected $categoria;

    /**
     * @ORM\Column(type="float")
     */
    protected $precio;

    /**
    * @param $descripcion
    * @param $precio
    */
    public function __construct($descripcion, $precio, $categoria)
    {
      $this->id = null;
      $this->descripcion = $descripcion;
      $this->precio = $precio;
      $this->categoria = $categoria;
    }

    public function getId(){return $this->id;}

    public function getDescripcion() {return $this->descripcion;}
    public function getCategoria()   {return $this->categoria;}
    public function getPrecio()      {return $this->precio;}

    public function setDescripcion($data)   {$this->descripcion = $data;}
    public function setCategoria($data)     {$this->categoria = $data;}
    public function setPrecio($data)        {$this->precio = $data;}
}