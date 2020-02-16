<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Cliente;
use App\Entities\Tarjeta;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class TarjetaController extends Controller
{
    function index(Request $r){
        $tarjetas=EntityManager::getRepository(Tarjeta::class);
        return view('crud.tarjetas',[
            'cliente_id' => $r->cliente_id,
            'list' => $tarjetas->findBy(['cliente' => $r->cliente_id]) 
                    ? $tarjetas->findBy(['cliente' => $r->cliente_id]) 
                    : [],
            'get' => $r->tarjeta_id ? $tarjetas->find($r->tarjeta_id) : null
        ]);
    }

    function save(Request $r){
        $tarjeta=null;
        $clientes=EntityManager::getRepository(Cliente::class);
        $cliente=$clientes->find($r->cliente_id);
        if ($r->id) { 
            $tarjetas=EntityManager::getRepository(Tarjeta::class);
            $tarjeta=$tarjetas->find($r->id);
            $tarjeta->setNombre($r->nombre);
            $tarjeta->setNumero($r->numero);
            $tarjeta->setDisponible($r->disponible);
            EntityManager::persist($tarjeta);
            EntityManager::flush();
        }else{
            $tarjeta=new Tarjeta($r->nombre, $r->numero, $r->disponible, $cliente);
            EntityManager::persist($tarjeta);
            EntityManager::flush();
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        $tarjetas=EntityManager::getRepository(Tarjeta::class);
        $tarjeta=$tarjetas->find($r->id);
        EntityManager::remove($tarjeta);
        EntityManager::flush();
        return Redirect::route('clientes');
    }
}
