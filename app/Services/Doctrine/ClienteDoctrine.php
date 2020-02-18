<?php
namespace App\Services\Doctrine;

use App\Api\ClienteService;
use App\Entities\Cliente;
use App\Entities\Tarjeta;
use Exception;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ClienteDoctrine implements ClienteService {
  public function crearCliente($nombre, $apellido, $dni, $email){
    try {
      $cliente=new Cliente($nombre, $apellido, $dni, $email);
      EntityManager::persist($cliente);
      EntityManager::flush();
    } catch(Exception $e) {
      if (strpos($e->getMessage(), 'Duplicate')  > -1){
        throw new Exception('El DNI no puede repetirse!');
      }
    }
    return true;
  }

  public function modificarCliente($cliente_id, $nombre, $apellido, $dni, $email){
    try {
      $cliente=EntityManager::getRepository(Cliente::class)->find($cliente_id);
      $cliente->setNombre($nombre);
      $cliente->setApellido($apellido);
      $cliente->setDni($dni);
      $cliente->setEmail($email);
      EntityManager::persist($cliente);
      EntityManager::flush();
    } catch(Exception $e) {
      if (strpos($e->getMessage(), 'Duplicate')  > -1){
        throw new Exception('El DNI no puede repetirse!');
      }
    }
    return true;
  }

  public function borrarCliente($cliente_id){
    try {
      $cliente=EntityManager::getRepository(Cliente::class)->find($cliente_id);
      EntityManager::remove($cliente);
      EntityManager::flush();
    } catch (Exception $e) {
      throw new Exception('El cliente tiene tarjetas asociadas');
    }
    return true;
  }

  public function listarClientes(){
    return EntityManager::getRepository(Cliente::class)->findAll();
  }

  public function obtenerCliente($cliente_id){
    return EntityManager::getRepository(Cliente::class)->find($cliente_id);
  }

  public function listarTarjetas($cliente_id){
    $tarjetas=EntityManager::getRepository(Tarjeta::class);
    return $tarjetas->findBy(['cliente' => $cliente_id]) 
            ? $tarjetas->findBy(['cliente' => $cliente_id]) 
            : [];
  }

  public function obtenerTarjeta($tarjeta_id){
    return EntityManager::getRepository(Tarjeta::class)->find($tarjeta_id);
  }

  public function crearTarjeta($nombre, $numero, $disponible, $cliente){
    $tarjeta=new Tarjeta($nombre, $numero, $disponible, $cliente);
    EntityManager::persist($tarjeta);
    EntityManager::flush();
    return true;
  }
  public function modificarTarjeta($tarjeta_id, $nombre, $numero, $disponible){
    $tarjeta=EntityManager::getRepository(Tarjeta::class)->find($tarjeta_id);
    $tarjeta->setNombre($nombre);
    $tarjeta->setNumero($numero);
    $tarjeta->setDisponible($disponible);
    EntityManager::persist($tarjeta);
    EntityManager::flush();
    return true;
  }
  public function borrarTarjeta($tarjeta_id){
    $tarjeta=EntityManager::getRepository(Tarjeta::class)->find($tarjeta_id);
    EntityManager::remove($tarjeta);
    EntityManager::flush();
    return true;
  }
}  