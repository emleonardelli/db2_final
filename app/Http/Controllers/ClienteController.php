<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Cliente;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ClienteController extends Controller
{
    function crearcliente(){
        $eze=new Cliente('Ezequiel', 'Mella', '12341234', 'email@gmail.com');
        EntityManager::persist($eze);
        EntityManager::flush();
    }
}
