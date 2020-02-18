<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ClienteDoctrine;
use Illuminate\Support\Facades\Redirect;

class TarjetaController extends Controller
{
    protected $cs;

    public function __construct(){
        $this->cs=new ClienteDoctrine();
    }

    function index(Request $r){
        return view('crud.tarjetas',[
            'cliente_id' => $r->cliente_id,
            'list' => $this->cs->listarTarjetas($r->cliente_id),
            'get' => $r->tarjeta_id ? $this->cs->obtenerTarjeta($r->tarjeta_id) : null
        ]);
    }

    function save(Request $r){
        $cliente=$this->cs->obtenerCliente($r->cliente_id);
        if ($r->id) { 
            $this->cs->modificarTarjeta($r->id, $r->nombre, $r->numero, $r->disponible);
        }else{
            $this->cs->crearTarjeta($r->nombre, $r->numero, $r->disponible, $cliente);
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        $this->cs->borrarTarjeta($r->id);
        return Redirect::route('clientes');
    }
}
