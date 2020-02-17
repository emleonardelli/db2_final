<?php
namespace App\Api;

interface ClienteService{
    // validar que el dni no se repita
    public function crearCliente($nombre, $apellido, $dni, $email);

    // validar que sea un cliente existente
    public function modificarCliente($cliente_id,$nombre, $apellido, $dni, $email);

    // validar que sea un cliente existente
    public function borrarCliente($cliente_id);

    public function listarClientes();
    public function obtenerCliente($cliente_id);
}