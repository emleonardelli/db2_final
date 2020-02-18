<?php
namespace App\Api;

interface ClienteService{
    public function crearCliente($nombre, $apellido, $dni, $email);
    public function modificarCliente($cliente_id,$nombre, $apellido, $dni, $email);
    public function borrarCliente($cliente_id);
    public function listarClientes();
    public function obtenerCliente($cliente_id);

    public function listarTarjetas($cliente_id);
    public function obtenerTarjeta($tarjeta_id);
    public function crearTarjeta($nombre, $numero, $disponible, $cliente);
    public function modificarTarjeta($cliente_id, $nombre, $numero, $disponible);
    public function borrarTarjeta($tarjeta_id);
}