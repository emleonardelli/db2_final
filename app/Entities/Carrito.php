<?php
namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entities\Producto;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;
use Exception;
use LaravelDoctrine\ORM\Facades\EntityManager;

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
     * @OneToOne(targetEntity="Cliente")
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
     * @ORM\Column(type="boolean")
     */
    protected $pagado;

    /**
     * @ORM\Column(type="string")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     */
    protected $fecha;

    /**
    * @param $cliente
    */
    public function __construct($cliente, $productos_id)
    {
      $this->id = null;
      $this->cliente = $cliente;
      $this->pagado = false;
      $this->descripcion = '';
      $this->fecha = null;
      $this->productos = new ArrayCollection();

      foreach ($productos_id as $var) {
        $producto=EntityManager::getRepository(Producto::class)->find($var);
        $this->addProducto($producto);
      }
    }

    public function getId(){return $this->id;}

    public function getCliente()     {return $this->cliente;}
    public function getProductos()   {return $this->productos;}
    public function getPagado()   {return $this->pagado;}
    public function getDescripcion()   {return $this->descripcion;}
    public function getFecha()   {return $this->fecha;}
    
    private function setFecha($data)   {$this->fecha = $data;}
    private function setCliente($data)     {$this->cliente = $data;}
    private function setDescripcion($data)     {$this->descripcion = $data;}
    public function addProducto($producto) {
      if(!$this->productos->contains($producto)) {
        $this->productos->add($producto);
      }
    }

    private function setPagado($data){
      $this->pagado = $data;
    }

    private function getSumaTotal(){
      $total=0;
      foreach ($this->getProductos() as $var) {
        $total+=$var->getPrecio();
      }
      return $total;
    }

    private function pagarCarrito(){
      $total=$this->getSumaTotal();
      $descripcion='
        Operacion Nro: '.$this->getId().' <br>
        Cliente: '.$this->getCliente()->getNombre().' '.$this->getCliente()->getApellido().',
        Email: '.$this->getCliente()->getEmail().'<br>
        Total de la compra: $ '.number_format($total, 2, ',', '.').'
        <br><br>
        Listado de productos
        <br>
      ';
      
      foreach ($this->getProductos() as $var) {
        $descripcion.=$var->getId().' '.
        $var->getDescripcion().' - $'.
        number_format($var->getPrecio(), 2, ',', '.').'<br>';
      }

      $this->setPagado(1);
      $this->setFecha(date('Y-m-d h:i:s'));
      $this->setDescripcion($descripcion);
    }

    public function confirmarCompra($tarjeta){
      $total=$this->getSumaTotal();
      try {
        $tarjeta->debitarMonto($total);
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }
      $this->pagarCarrito();
    }
}