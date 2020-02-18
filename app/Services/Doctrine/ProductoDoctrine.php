<?php
namespace App\Services\Doctrine;

use App\Api\ProductoService;
use App\Entities\Categoria;
use App\Entities\Marca;
use App\Entities\Producto;
use Exception;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductoDoctrine implements ProductoService {
  public function listarCategorias(){
    return EntityManager::getRepository(Categoria::class)->findAll();
  }

  public function obtenerCategoria($categoria_id){
    return EntityManager::getRepository(Categoria::class)->find($categoria_id);
  }

  public function crearCategoria($nombre, $descripcion){
    $categoria=new Categoria($nombre, $descripcion);
    EntityManager::persist($categoria);
    EntityManager::flush();
  }

  public function modificarCategoria($categoria_id, $nombre, $descripcion){
    $categoria=EntityManager::getRepository(Categoria::class)->find($categoria_id);
    $categoria->actualizarDatos($nombre, $descripcion);
    EntityManager::persist($categoria);
    EntityManager::flush();
  }

  public function borrarCategoria($categoria_id){
    try {
      $categoria=EntityManager::getRepository(Categoria::class)->find($categoria_id);
      EntityManager::remove($categoria);
      EntityManager::flush();
    } catch (Exception $e) {
        throw new Exception('La categoria seleccionada tiene productos asignados, no puede ser eliminada!');
    }
  }

  public function listarMarcas(){
    return EntityManager::getRepository(Marca::class)->findAll();
  }

  public function obtenerMarca($marca_id){
    return EntityManager::getRepository(Marca::class)->find($marca_id);
  }

  public function crearMarca($nombre, $descripcion){
    $marca=new Marca($nombre, $descripcion);
    EntityManager::persist($marca);
    EntityManager::flush();
  }

  public function modificarMarca($marca_id, $nombre, $descripcion){
    $marca=EntityManager::getRepository(Marca::class)->find($marca_id);
    $marca->actualizarDatos($nombre, $descripcion);
    EntityManager::persist($marca);
    EntityManager::flush();
  }

  public function borrarMarca($marca_id){
    try {
      $marca=EntityManager::getRepository(Marca::class)->find($marca_id);
      EntityManager::remove($marca);
      EntityManager::flush();
    } catch (Exception $e) {
      throw new Exception('La marca seleccionada tiene productos asignados, no puede ser eliminada!');
    }
  }

  public function listarProductos(){
    return EntityManager::getRepository(Producto::class)->findAll();
  }

  public function obtenerProducto($producto_id){
    return EntityManager::getRepository(Producto::class)->find($producto_id);
  }

  public function crearProducto($descripcion, $precio, $categoria, $marca){
    $producto=new Producto($descripcion, $precio, $categoria, $marca);
    EntityManager::persist($producto);
    EntityManager::flush();
  }

  public function modificarProducto($producto_id, $descripcion, $precio, $categoria, $marca){
    $producto=EntityManager::getRepository(Producto::class)->find($producto_id);
    $producto->actualizarDatos($descripcion, $precio, $categoria, $marca);
    EntityManager::persist($producto);
    EntityManager::flush();
  }

  public function borrarProducto($producto_id){
    $producto=EntityManager::getRepository(Producto::class)->find($producto_id);
    EntityManager::remove($producto);
    EntityManager::flush();
  }
}  