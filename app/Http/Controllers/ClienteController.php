<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\Doctrine\ClienteDoctrine;
use Exception;

class ClienteController extends Controller
{
    protected $cs;

    public function __construct(){
        $this->cs=new ClienteDoctrine();
    }

    function index(Request $r){
        return view('crud.clientes',[
            'list' => $this->cs->listarClientes(),
            'get' => $r->id ? $this->cs->obtenerCliente($r->id) : null
        ]);
    }

    function save(Request $r){
        try {
            if ($r->id) { 
                $this->cs->modificarCliente($r->id, $r->nombre,$r->apellido,$r->dni,$r->email);
            }else{
                $this->cs->crearCliente($r->nombre,$r->apellido,$r->dni,$r->email);
            }
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('clientes');
    }

    function remove(Request $r){
        try {
            $this->cs->borrarCliente($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('clientes');
    }
}
