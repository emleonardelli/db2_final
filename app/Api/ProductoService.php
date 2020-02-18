<?php
namespace App\Api;

interface ProductoService{
    public function listarCategorias();
    public function obtenerCategoria($categoria_id);
    public function crearCategoria($nombre, $descripcion);
    public function modificarCategoria($categoria_id, $nombre, $descripcion);
    public function borrarCategoria($categoria_id);

    public function listarMarcas();
    public function obtenerMarca($marca_id);
    public function crearMarca($nombre, $descripcion);
    public function modificarMarca($marca_id, $nombre, $descripcion);
    public function borrarMarca($marca_id);

    public function listarProductos();
    public function obtenerProducto($producto_id);
    public function crearProducto($descripcion, $precio, $categoria, $marca);
    public function modificarProducto($producto_id, $descripcion, $precio, $categoria, $marca);
    public function borrarProducto($producto_id);
}