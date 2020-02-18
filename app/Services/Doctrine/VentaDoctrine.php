<?php
namespace App\Services\Doctrine;

use App\Api\VentaService;
use App\Entities\Carrito;
use LaravelDoctrine\ORM\Facades\EntityManager;
use App\Entities\Categoria;
use App\Entities\Marca;
use App\Entities\Producto;
use Exception;

class VentaDoctrine implements VentaService {
  public function listarCarritos(){
    return EntityManager::getRepository(Carrito::class)->findAll();
  }

  public function obtenerCarrito($carrito_id){
    return EntityManager::getRepository(Carrito::class)->find($carrito_id);
  }

  public function guardarCarrito($cliente, $productos_id){
    $carrito=new Carrito($cliente);
    foreach ($productos_id as $var) {
        $producto=EntityManager::getRepository(Producto::class)->find($var);
        $carrito->addProducto($producto);
    }
    EntityManager::persist($carrito);
    EntityManager::flush();
    return true;
  }

  public function borrarCarrito($carrito_id){
    $carrito=EntityManager::getRepository(Carrito::class)->find($carrito_id);
    EntityManager::remove($carrito);
    EntityManager::flush();
  }

  public function pagarCarrito($carrito, $tarjeta){
    $total=0;
    foreach ($carrito->getProductos() as $var) {
      $total+=$var->getPrecio();
    }

    if ($total > $tarjeta->getDisponible()){
      throw new Exception('Limite superado');
    }

    $tarjeta->setDisponible($tarjeta->getDisponible()-$total);
    EntityManager::persist($tarjeta);
    EntityManager::flush();

    $descripcion='
        Operacion Nro: '.$carrito->getId().' <br>
        Cliente: '.$carrito->getCliente()->getNombre().' '.$carrito->getCliente()->getApellido().',
        Email: '.$carrito->getCliente()->getEmail().'<br>
        Total de la compra: $ '.number_format($total, 2, ',', '.').'
        <br><br>
        Listado de productos
        <br>
    ';
    
    foreach ($carrito->getProductos() as $var) {
        $descripcion.=$var->getId().' '.
            $var->getDescripcion().' - $'.
            number_format($var->getPrecio(), 2, ',', '.').'<br>';
    }

    $carrito->setPagado(1);
    $carrito->setFecha(date('Y-m-d h:i:s'));
    $carrito->setDescripcion($descripcion);
    EntityManager::persist($carrito);
    EntityManager::flush();
    return true;
  }

  public function listarPagos(){
    return EntityManager::getRepository(Carrito::class)->findBy(['pagado' => true]);
  }
}  