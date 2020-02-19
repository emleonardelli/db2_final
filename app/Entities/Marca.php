<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Producto;

/**
 * @ORM\Entity
 * @ORM\Table(name="marca")
 */
class Marca
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
     * @ORM\Column(type="string")
     */
    protected $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="producto", cascade={"persist"})
     * @var ArrayCollection|Producto[]
    */
    protected $productos;

    /**
    * @param $nombre
    * @param $descripcion
    */
    public function __construct($nombre, $descripcion)
    {
      $this->id = null;
      $this->nombre = $nombre;
      $this->descripcion = $descripcion;

      $this->productos = new ArrayCollection();
    }

    public function getId(){return $this->id;}

    public function getNombre()       {return $this->nombre;}
    public function getDescripcion()  {return $this->descripcion;}
    public function getProductos()     {return $this->productos;}  

    private function setNombre($data)      {$this->nombre = $data;}
    private function setDescripcion($data) {$this->descripcion = $data;}
    public function addProducto(Producto $producto){
      if(!$this->productos->contains($producto)) {
        $producto->setMarca($this);
        $this->productos->add($producto);
      }
    }
    public function popProducto(Producto $producto){
      if(!$this->productos->contains($producto)) {
        $this->productos->remove($producto);
      }
    }

    public function actualizarDatos($nombre, $descripcion){
      $this->nombre=$nombre;
      $this->descripcion = $descripcion;
    }
        
}




    