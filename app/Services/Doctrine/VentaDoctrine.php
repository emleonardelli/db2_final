<?php
namespace App\Services\Doctrine;

use App\Api\VentaService;
use App\Entities\Carrito;
use App\Entities\Producto;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Exception;

class VentaDoctrine implements VentaService {
  public function listarCarritos(){
    return EntityManager::getRepository(Carrito::class)->findAll();
  }

  public function obtenerCarrito($carrito_id){
    return EntityManager::getRepository(Carrito::class)->find($carrito_id);
  }

  public function guardarCarrito($cliente, $productos_id){
    $productos=[];
    foreach($productos_id as $var){
      array_push($productos, EntityManager::getRepository(Producto::class)->find($var));
    }
    $carrito=new Carrito($cliente, $productos);
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
    try {
      $carrito->confirmarCompra($tarjeta);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    EntityManager::persist($carrito);
    EntityManager::persist($tarjeta);
    EntityManager::flush();
    return true;
  }

  public function listarPagos(){
    return EntityManager::getRepository(Carrito::class)->findBy(['pagado' => true]);
  }
}  