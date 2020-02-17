<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Producto;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;

/**
 * @ORM\Entity
 * @ORM\Table(name="carrito")
 */
class Carrito
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Cliente")
     * @JoinColumn(name="cliente_id", referencedColumnName="id")
     * @var Cliente
    */
    protected $cliente;

    /**
     * One Product has One Category.
     * @ManyToMany(targetEntity="Producto")
     * @JoinTable(name="carritos_productos",
     *      joinColumns={@JoinColumn(name="carrito_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="producto_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection|Producto[]
    */
    protected $productos;

    /**
    * @param $cliente
    */
    public function __construct($cliente)
    {
      $this->id = null;
      $this->cliente = $cliente;
      $this->productos = new ArrayCollection();
    }

    public function getId(){return $this->id;}

    public function getCliente()     {return $this->cliente;}
    public function getProductos()   {return $this->productos;}

    public function setCliente($data)     {$this->cliente = $data;}
    public function addProducto($producto) {
      if(!$this->productos->contains($producto)) {
        $this->productos->add($producto);
      }
    }
}