<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\Doctrine\ClienteDoctrine;
use Exception;

class ClienteController extends Controller
{
    function index(Request $r){
        $cs=new ClienteDoctrine();
        return view('crud.clientes',[
            'list' => $cs->listarClientes(),
            'get' => $r->id ? $cs->obtenerCliente($r->id) : null
        ]);
    }

    function save(Request $r){
        $cs=new ClienteDoctrine();
        try {
            if ($r->id) { 
                $cs->modificarCliente($r->id, $r->nombre,$r->apellido,$r->dni,$r->email);
            }else{
                $cs->crearCliente($r->nombre,$r->apellido,$r->dni,$r->email);
            }
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        $cs=new ClienteDoctrine();
        try {
            $cs->borrarCliente($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('clientes');
    }
}
