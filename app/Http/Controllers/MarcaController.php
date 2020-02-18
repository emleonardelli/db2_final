<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Marca;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class MarcaController extends Controller
{
    protected $ps;

    public function __construct(){
        $this->ps=new ProductoDoctrine(); 
    }

    function index(Request $r){
        return view('crud.marcas',[
            'list' => $this->ps->listarMarcas(),
            'get' => $r->id ? $this->ps->obtenerMarca($r->id) : null
        ]);
    }

    function save(Request $r){
        if ($r->id) { 
            $this->ps->modificarMarca($r->id, $r->nombre, $r->descripcion);
        }else{
            $this->ps->crearMarca($r->nombre, $r->descripcion);
        }
        return Redirect::route('marcas');
    }

    function remove(Request $r){
        try {
            $this->ps->borrarMarca($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('marcas');
    }
}
