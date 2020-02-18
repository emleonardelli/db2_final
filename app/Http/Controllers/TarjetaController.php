<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ClienteDoctrine;
use Illuminate\Support\Facades\Redirect;

class TarjetaController extends Controller
{
    function index(Request $r){
        $cs=new ClienteDoctrine();
        return view('crud.tarjetas',[
            'cliente_id' => $r->cliente_id,
            'list' => $cs->listarTarjetas($r->cliente_id),
            'get' => $r->tarjeta_id ? $cs->obtenerTarjeta($r->tarjeta_id) : null
        ]);
    }

    function save(Request $r){
        $cs=new ClienteDoctrine();
        $cliente=$cs->obtenerCliente($r->cliente_id);
        if ($r->id) { 
            $cs->modificarTarjeta($r->id, $r->nombre, $r->numero, $r->disponible);
        }else{
            $cs->crearTarjeta($r->nombre, $r->numero, $r->disponible, $cliente);
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        $cs=new ClienteDoctrine();
        $cs->borrarTarjeta($r->id);
        return Redirect::route('clientes');
    }
}
