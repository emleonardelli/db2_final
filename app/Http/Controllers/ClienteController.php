<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Cliente;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ClienteController extends Controller
{
    function crearcliente(){
        $eze=new Cliente('Ezequiel', 'Mella', '12341234', 'email@gmail.com');
        EntityManager::persist($eze);
        EntityManager::flush();
    }

    function index(Request $r){
        $clientes=EntityManager::getRepository(Cliente::class);

        return view('crud.clientes',[
            'list' => $clientes->findAll(),
            'get' => $r->id ? $clientes->find($r->id) : null
        ]);
    }

    function save(Request $r){
        $cliente=null;
        if ($r->id) { 
            $clientes=EntityManager::getRepository(Cliente::class);
            $cliente=$clientes->find($r->id);
            $cliente->setNombre($r->nombre);
            $cliente->setApellido($r->apellido);
            $cliente->setDni($r->dni);
            $cliente->setEmail($r->email);
            EntityManager::persist($cliente);
            EntityManager::flush();
        }else{
            $cliente=new Cliente($r->nombre, $r->apellido, $r->dni, $r->email);
            EntityManager::persist($cliente);
            EntityManager::flush();
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        $clientes=EntityManager::getRepository(Cliente::class);
        $cliente=$clientes->find($r->id);
        EntityManager::remove($cliente);
        EntityManager::flush();
        return Redirect::route('clientes');
    }
}
