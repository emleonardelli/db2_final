<?php
namespace App\Api;

interface VentaService{
    public function listarCarritos();
    public function obtenerCarrito($carrito_id);
    public function guardarCarrito($cliente, $productos_id);
    public function borrarCarrito($carrito_id);
    
    public function pagarCarrito($carrito, $tarjeta);
    public function listarPagos();
}